<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $table = 'Item'; // table name
    protected $primaryKey = 'id'; // primary key
    public $timestamps = true; // timestamps
}
