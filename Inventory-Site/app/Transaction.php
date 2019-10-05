<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $table = 'Order_Transaction'; // table name
    protected $primaryKey = 'id'; // primary key
    public $timestamps = true; // timestamps

    public function Transaction()
    {
        // Define the table relationships
        $this->belongsTo(User::Class);
        $this->belongsTo(Item::Class);
    }


}
