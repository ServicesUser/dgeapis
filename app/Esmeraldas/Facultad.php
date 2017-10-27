<?php

namespace App\Esmeraldas;

use Illuminate\Database\Eloquent\Model;

class Facultad extends Model{
    protected $table        =   'facultades_e';
    protected $primaryKey   =   'id_fe';
    public $timestamps      =   false;
}
