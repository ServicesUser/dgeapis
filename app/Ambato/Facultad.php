<?php

namespace App\Ambato;

use Illuminate\Database\Eloquent\Model;

class Facultad extends Model{
    protected $table        =   'facultades_a';
    protected $primaryKey   =   'id_fa';
    public $timestamps      =   false;
}
