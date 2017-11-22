<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Address extends Model {
    protected $table = 'endereco';
    protected $primaryKey = 'id';
    public $timestamps = false;
}
