<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Facultades extends Model{
    protected $table        =   'facultades';
    protected $primaryKey   =   'ID_FAC';
    public $timestamps      =   false;
    protected $connection   =   'basep';
}
