<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Carreras extends Model{
    protected $table        =   'escuelas';
    protected $primaryKey   =   'CODIGO_ESC';
    public $timestamps      =   false;
    protected $connection   =   'basep';
}
