<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CV extends Model{
    protected $table        =   'cv';
    protected $primaryKey   =   'CODIGO_CV';
    public $timestamps      =   false;
    protected $connection   =   'basep';
}
