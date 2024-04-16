<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;

    //protected $fillable=['nombre','email','telefono','dirreccion'];
    protected $guarded =['id', 'created_at', 'update_at'];
    
    //relacion un a ,ucho inversa
    public function user(){
        return $this->belongsTo(User::class);
        
    }
    public function movimiento(){       

        return $this->hasMany(Movimiento::class);
    }
}
