<?php

namespace App\Manabi;

use Illuminate\Database\Eloquent\Model;

class Facultad extends Model{
    protected $table        =   'facultades_m';
    protected $primaryKey   =   'id_fm';
    public $timestamps      =   false;
}
