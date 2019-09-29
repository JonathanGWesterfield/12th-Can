<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $table = 'Order_Transaction'; // table name
    protected $primaryKey = 'id'; // primary key
    public $timestamps = true; // timestamps
}
