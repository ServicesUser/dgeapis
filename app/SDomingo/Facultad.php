<?php

namespace App\SDomingo;

use Illuminate\Database\Eloquent\Model;

class Facultad extends Model{
    protected $table        =   'facultades_s';
    protected $primaryKey   =   'id_fs';
    public $timestamps      =   false;
}
