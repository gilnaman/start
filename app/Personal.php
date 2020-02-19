<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Personal extends Model
{
    protected $table='personal';
    protected $primaryKey='noreferencia';

    //puapblic $timestamps=false;
    //public $incrementing=false;

    // public $fillable=[
    // 	'',
    // 	'nombre',
    // 	'descripcion',
    // 	'activo',
    // 	'credito'
    // ];
}
