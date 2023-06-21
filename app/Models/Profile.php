<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;

    //? Proteccion: se insertan las columnas que no se van a asignar masivamente, el opuesto de $fillable
    protected $guarded = [
        'id',
        'created_at',
        'updated_at'
    ];

    //? Relacion de uno a uno inversa (profile-user)

    public function user(){
        return $this->belongsTo(User::class);
    }
}
