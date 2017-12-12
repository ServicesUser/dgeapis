<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Estudiantes extends Model{
    protected $table        =   'estudiantes';
    protected $primaryKey   =   'CI_EST';
    public $timestamps      =   false;
    protected $connection   =   'basep';
}
