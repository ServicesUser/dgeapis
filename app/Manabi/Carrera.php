<?php

namespace App\Manabi;

use Illuminate\Database\Eloquent\Model;

class Carrera extends Model{
    protected $table        =   'carreras_m';
    protected $primaryKey   =   'id_cm';
    public $timestamps      =   false;

    public function facultad(){
        return $this->hasMany('App\Manabi\Facultad','id_fm');
    }
}
