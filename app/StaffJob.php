<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StaffJob extends Model
{
    protected $fillable = [
        'name'
    ];

    public function staffs(){
        return $this->hasMany('App\Staff');
    }
}
