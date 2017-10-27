<?php

namespace App\Esmeraldas;

use Illuminate\Database\Eloquent\Model;

class Carrera extends Model{
    protected $table        =   'carreras_e';
    protected $primaryKey   =   'id_ce';
    public $timestamps      =   false;
}
