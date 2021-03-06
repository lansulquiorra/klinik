<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    protected $appends = ['result'];

    protected $fillable = [
        'number_medical_record',
        'full_name',
        'place',
        'birth',
        'age',
        'gender',
        'address',
        'religion',
        'province',
        'city',
        'district',
        'sub_district',
        'rt_rw',
        'phone_number',
        'last_education',
        'job',
        'askes_number',
        'room_id'
    ];


    /*belong*/
    public function hospital(){
        return $this->belongsTo('App\Hospital', 'hospital_id', 'id');
    }

    public function registers(){
        return $this->hasMany('App\Register');
    }

    public function debts(){
        return $this->registers()->where('payment_status', '=', 0)->orWhere('payment_status', '=', null);
    }

    public function transactions(){
        return $this->hasMany('App\Transaction');
    }

    public function RegisterInpatients(){
        return $this->hasMany('App\RegisterInpatient');
    }

    /*mutator set*/
    public function setBirthAttribute($value)
    {
        if ($value) {
            $this->attributes['birth'] = Carbon::createFromFormat('d/m/Y', $value);
        }
    }

    public function getBirthAttribute($value)
    {
        return Carbon::parse($value)->format('d/m/Y');
    }

    public function getResultAttribute()
    {
        return $this->attributes['number_medical_record']. ' - '. $this->attributes['full_name'];
    }

    public function room(){
        return $this->belongsTo('App\Room', 'room_id', 'id');
    }

    public function bed(){
        return $this->hasOne('App\Bed');
    }
}
