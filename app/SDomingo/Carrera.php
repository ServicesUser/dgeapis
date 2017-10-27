<?php

namespace App\SDomingo;

use Illuminate\Database\Eloquent\Model;

class Carrera extends Model{
    protected $table        =   'carreras_s';
    protected $primaryKey   =   'id_cs';
    public $timestamps      =   false;
}
