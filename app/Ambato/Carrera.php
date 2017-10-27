<?php

namespace App\Ambato;

use Illuminate\Database\Eloquent\Model;

class Carrera extends Model{
    protected $table        =   'carreras_a';
    protected $primaryKey   =   'id_ca';
    public $timestamps      =   false;
}
