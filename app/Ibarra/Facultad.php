<?php

namespace App\Ibarra;

use Illuminate\Database\Eloquent\Model;

class Facultad extends Model{
    protected $table        =   'facultades_i';
    protected $primaryKey   =   'id_fi';
    public $timestamps      =   false;
}
