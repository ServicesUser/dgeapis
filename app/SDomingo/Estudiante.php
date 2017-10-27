<?php

namespace App\SDomingo;

use Illuminate\Database\Eloquent\Model;

class Estudiante extends Model{
    protected $table        =   'sdomingo';
    protected $primaryKey   =   false;
    public $timestamps      =   false;
    public $incrementing    =   false;
}
