<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Measurers extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_user',
        'city',
        'state',
        'district',
        'street',
        'cep',
        'complement'
    ];
    public function user(){
        return $this->belongsTo(User::class, 'id_user', 'id');
    }


    public function measures(){
        return $this->hasMany(Measures::class,'id_measurer','id');
    }
}
