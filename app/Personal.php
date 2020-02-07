<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Personal extends Model
{
    protected $table='personal';
    protected $primaryKey='noreferencia';

    //public $timestamps=false;
    //public $incrementing=false;

    // public $fillable=[
    // 	'',
    // 	'nombre',
    // 	'descripcion',
    // 	'activo',
    // 	'credito'
    // ];
}
