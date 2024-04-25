<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movimiento extends Model
{
    use HasFactory;
//relacion un a ,ucho inversa


protected $guarded=['id','created_at', 'updated_at'];

public function cliente(){
    return $this->belongsTo(Cliente::class);
    
}
    public function user(){
        return $this->belongsTo(User::class);
        
    }
    public function cuenta(){
        return $this->belongsTo(Cuenta::class);

    }
    public function cambio(){

        return $this->belongsTo(Cambio::class);
    }
}
