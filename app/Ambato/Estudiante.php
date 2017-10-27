<?php

namespace App\Ambato;

use Illuminate\Database\Eloquent\Model;

class Estudiante extends Model{
    protected $table        =   'ambato';
    protected $primaryKey   =   false;
    public $timestamps      =   false;
    public $incrementing    =   false;
}
