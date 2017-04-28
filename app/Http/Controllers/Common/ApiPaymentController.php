<?php

namespace App\Http\Controllers\Common;

use App\Patient;
use App\Payment;
use App\Register;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ApiPaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $response = [];
        try {
            $registers = Register::with(['references', 'references.poly', 'references.payments', 'references.payments.service'])->get();
            foreach ($registers as $register){
                foreach ($register->references as $reference){
                    $reference['reference_total_payment'] = 0;
                    foreach ($reference->payments as $payment){
                        $reference['reference_total_payment'] += $payment->total;
                    }
                }
            }
            $response = ['isSuccess' => true, 'message' => 'Success / Berhasil', 'datas' => ['registers' => $registers, 'recordsTotal' => count($registers)]];
        } catch (\Exception $e) {
            $response = ['isSuccess' => false, 'message' => $e->getMessage(), 'datas' => null, 'code' => $e->getCode()];
        }
        return response()->json($response);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $response = [];
        try {
            $payments = Payment::with(['reference', 'reference.medicalRecords', 'reference.medicalRecords.service', 'reference.poly', 'register', 'register.patient'])->where('register_id', $request['register_id'])->get();
            $patient = Patient::whereHas('registers', function ($q) use ($request) {
                $q->where('id', $request['register_id']);
            })->first();
            $total_payment = 0;
            $remaining = 0;

            foreach ($payments as $payment) {
                if ($payment->status == 1) {
                    $remaining += $payment->total;
                }
                $total_payment += $payment->total;
            }

            $payments['recordsTotal'] = count($payments);
            $response = ['isSuccess' => true, 'message' => 'Success / Berhasil', 'datas' => ['payments' => $payments, 'patient' => $patient, 'total_payment' => $total_payment, 'remaining' => $remaining]];
        } catch (\Exception $e) {
            $response = ['isSuccess' => false, 'message' => $e->getMessage(), 'datas' => null, 'code' => $e->getCode()];
        }
        return response()->json($response);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $response = [];
        try {
            $input = $request->all();
            $register = Register::with(['payments'])->find($input['register_id']);
            $total_payment = 0;
            foreach ($register->payments as $payment){
                $total_payment += $payment->total;
            }

            /*main logic*/
            $result = $total_payment - $input['payment'];
            if($result <= 0){
                foreach ($register->payments as $payment){
                    $payment->update([
                        'status' => 2
                    ]);
                }
            }

            return $result;


            $response = ['isSuccess' => true, 'message' => 'Success / Berhasil', 'datas' => ['payment' => $payment]];

        } catch (\Exception $e) {
            $response = ['isSuccess' => false, 'message' => $e->getMessage(), 'datas' => null, 'code' => $e->getCode()];
        }
        return response()->json($response);
    }
}
