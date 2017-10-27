<?php

namespace App\Ibarra;

use Illuminate\Database\Eloquent\Model;

class Carrera extends Model{
    protected $table        =   'carreras_i';
    protected $primaryKey   =   'id_ci';
    public $timestamps      =   false;
}
