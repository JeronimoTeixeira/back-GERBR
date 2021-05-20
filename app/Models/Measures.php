<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Measures extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_measurer',
        'value',
        'date'
    ];
    public function measurer(){
        return $this->belongsTo(User::class, 'id_user', 'id');
    }
}
