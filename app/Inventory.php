<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    protected $fillable = [
        'code',
        'name',
        'category',
        'type',
        'explain',
        'sediaan',
        'price'
    ];

    public function batches(){
        return $this->hasMany('App\Batch');
    }

    public function pharmacySellers(){
        return $this->hasMany('App\PharmacySeller');
    }

    public function depos(){
        return $this->belongsToMany('App\Depo', 'inventories_depos', 'inventories_id', 'depos_id');
    }

}
