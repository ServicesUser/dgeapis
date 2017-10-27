<?php

namespace App\Esmeraldas;

use Illuminate\Database\Eloquent\Model;

class Estudiante extends Model{
    protected $table        =   'esmeraldas';
    protected $primaryKey   =   false;
    public $timestamps      =   false;
    public $incrementing    =   false;
}
