<?php

namespace App\Ibarra;

use Illuminate\Database\Eloquent\Model;

class Estudiante extends Model{
    protected $table        =   'ibarra';
    protected $primaryKey   =   false;
    public $timestamps      =   false;
    public $incrementing    =   false;
}
