<?php

namespace App\Manabi;

use Illuminate\Database\Eloquent\Model;

class Estudiante extends Model{
    protected $table        =   'manabi';
    protected $primaryKey   =   false;
    public $timestamps      =   false;
    public $incrementing    =   false;
}
