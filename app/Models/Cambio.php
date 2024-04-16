<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cambio extends Model
{
    use HasFactory;
     //Relacion de uno a muchos

     protected $fillable = ['nombre'];

     public function movimientos(){

        return $this->hasMany(Movimiento::class);

    }
}
