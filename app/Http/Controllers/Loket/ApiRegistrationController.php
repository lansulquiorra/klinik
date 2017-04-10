<?php

namespace App\Http\Controllers\Loket;

use App\Hospital;
use App\Http\Controllers\GeneralController;
use App\Kiosk;
use App\Patient;
use App\Poly;
use App\Register;
use App\Staff;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use File;
use Illuminate\Support\Facades\Auth;
use Yajra\Datatables\Facades\Datatables;

class ApiRegistrationController extends GeneralController
{
    public function index()
    {
        $response = [];
        try {
            $user = User::find(Auth::user()->id);
            $response = ['isSuccess' => true, 'message' => 'Success / Berhasil', 'datas' => ['user' => $user]];
        } catch (\Exception $e) {
            $response = ['isSuccess' => false, 'message' => $e->getMessage(), 'datas' => null, 'code' => $e->getCode()];
        }
        return response()->json($response);
    }

    public function getList(Request $request)
    {
        $response = [];
        try {
            $registers = Register::with(['patient', 'staff'])->get();
            $datatable = Datatables::of($registers);
            $response = ['isSuccess' => true, 'message' => 'Success / Berhasil', 'datas' => $datatable->make(true)];
        } catch (\Exception $e) {
            $response = ['isSuccess' => false, 'message' => $e->getMessage(), 'datas' => null, 'code' => $e->getCode()];
        }

        return response()->json($response);
    }

    public function CreateEdit(Request $request)
    {
        $response = [];
        try {
            /*update kiosk to status on process*/
            $kiosk_id = $request->query('kiosk_id');
            $kiosk = null;
            if ($kiosk_id) {
                $kiosk = Kiosk::find($kiosk_id);
                $kiosk->update([
                    'status' => 3, /*1:open, 2:calling, 3:on process, 4:finished*/
                    'staff_id' => Auth::user()->id
                ]);
                $filename = 'sounds/temp/' . $kiosk->queue_number . '_' . $kiosk->type . '.mp3';
                File::delete($filename);
            }

            /*get polies*/
            $polies = Poly::get();
            $polies['recordsTotal'] = count($polies);

            /*get staff where staffjob doctor*/
            $doctors = Staff::whereHas('staffJob', function ($q) {
                $q->where('name', 'Dokter');
            })->get();
            $doctors['recordsTotal'] = count($doctors);

            /*get hospital*/
            $hospital = Hospital::first();

            /*get staff role loket who is logged on*/
            $staff = Staff::where('user_id', Auth::user()->id)->first();

            $response = ['isSuccess' => true, 'message' => 'Success / Berhasil', 'datas' => ['polies' => $polies, 'doctors' => $doctors, 'hospital' => $hospital, 'kiosk' => $kiosk, 'staff' => $staff]];
        } catch (\Exception $e) {
            $response = ['isSuccess' => false, 'message' => $e->getMessage(), 'datas' => null, 'code' => $e->getCode()];
        }
        return response()->json($response);
    }

    public function selectPoly(Request $request)
    {
        $response = [];
        try {
            $poly = Poly::with(['doctors'])->find($request['id']);
            $response = ['isSuccess' => true, 'message' => 'Success / Berhasil', 'datas' => ['poly' => $poly]];
        } catch (\Exception $e) {
            $response = ['isSuccess' => false, 'message' => $e->getMessage(), 'datas' => null, 'code' => $e->getCode()];
        }

        return response()->json($response);
    }

    public function getPatient(Request $request)
    {
        $response = [];
        try {
            $patient = Patient::where('full_name', 'LIKE', '%' . $request->query('query') . '%')
                ->orWhere('number_medical_record', 'LIKE', '%' . $request->query('query') . '%')->get();
            $response = ['isSuccess' => true, 'message' => 'Success / Berhasil', 'datas' => ['patient', $patient]];
        } catch (\Exception $e) {
            $response = ['isSuccess' => false, 'message' => $e->getMessage(), 'datas' => null, 'code' => $e->getCode()];
        }

        return response()->json($response);
    }

    public function store(Request $request)
    {
        $response = [];
        try {
            $input = $request->all();

            /*update kiosk status to finished*/
            if ($input['kiosk_id']) {
                $kiosk = Kiosk::find($input['kiosk_id']);
                if ($kiosk) {
                    $kiosk->update(['status' => 4]);

                }
            }

            /*add hospoital id to input for create patient*/
            $hospital = Hospital::first();
            $input['hospital_id'] = $hospital->id;

            /*select patient from database or create new*/
            if ($input['patient_number_id']) {
                $patient = Patient::find($input['patient_number_id']);
            } else {
                $patient = Patient::create($input);
            }

            /*define user logged*/
            $user = User::with('staff')->find(Auth::user()->id);

            /*add input data for create new register */
            $input['register_number'] = Carbon::now()->format('Ymdhis');
            $input['staff_id'] = $user->staff->id;
            $input['patient_id'] = $patient->id;
            $input['status'] = 1;

            /*create type registration*/
            $register = Register::create($input);


            /*add reference to poly*/
            $reference = $this->addReference($input, $register, 'create');

            /*assign payment for doctor / create payment for doctor*/
            $doctor = Staff::with('doctorService')->find($input['doctor']);
            $register->payments()->create([
                'status' => 1,
                'total' => $doctor->doctorService->cost,
                'type' => 'doctor_service',
            ]);


            /*add kiosk queue in poly*/
            $poly = Poly::find($request['poly']);
            $kiosk = $this->getKioskQueue($poly->name, $reference->id);

            $response = ['isSuccess' => true, 'message' => 'Success / Berhasil', 'datas' => ['patient' => $patient, 'reference' => $reference, 'poly' => $poly, 'kiosk' => $kiosk, 'register' => $register, 'doctor' => $doctor]];
        } catch (\Exception $e) {
            $response = ['isSuccess' => false, 'message' => $e->getMessage(), 'datas' => null, 'code' => $e->getCode()];
        }
        return response()->json($response);
    }

    public function getReference(Request $request){
        $response = [];
        try{
            /*get polies*/
            $polies = Poly::get();
            $polies['recordsTotal'] = count($polies);

            /*get doctors*/
            $doctors = Staff::whereHas('staffJob', function ($q) {
                $q->where('name', 'Dokter');
            })->get();
            $doctors['recordsTotal'] = count($doctors);

            $hospital = Hospital::first();
            $register = Register::with(['patient', 'references', 'references.poly', 'references.doctor'])->find($request['id']);

            $response = ['isSuccess' => true, 'message' => 'Success / Berhasil', 'datas' => ['polies' => $polies, 'doctors' => $doctors, 'hospital' => $hospital, 'register' => $register]];
        } catch (\Exception $e){
            $response = ['isSuccess' => false, 'message' => $e->getMessage(), 'datas' => null, 'code' => $e->getCode()];
        }

        return response()->json($response);
    }

    public function postReference(Request $request){
        $response = [];
        try{
            $input = $request->all();
            $reference = $this->addReference($input, '', 'add');
            $poly = Poly::find($input['poly']);
            $kiosk = $this->getKioskQueue($poly->name, $reference->id);

            $response = ['isSuccess' => true, 'message' => 'Success / Berhasil', 'datas' => []];
        } catch (\Exception $e){
            $response = ['isSuccess' => false, 'message' => $e->getMessage(), 'datas' => null, 'code' => $e->getCode()];
        }

        return response()->json($response);
    }


}
