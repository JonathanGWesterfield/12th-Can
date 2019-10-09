<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

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

    /**
     * Allows us to get the current quantity for an item in the database.
     *
     * @param $itemId The id of the item we are trying to get the current quantity for.
     */
    public function quantity($itemId)
    {
        $quantity = DB::table('Order_Transaction')
            ->sum('item_quantity_change')
            ->where('item_id', $itemId);

        return $quantity;
    }


}
