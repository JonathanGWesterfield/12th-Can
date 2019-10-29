<?php

use Illuminate\Database\Seeder;

class OrderTransactionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('Order_Transaction')->insert([
                   'id' => 1,
                   'member_id' => 7,
                   'item_id'=> 2,
                   'item_quantity_change' => 69,
                   'comment' => 'Nice',
                   'transaction_date' => '2019-10-16 18:01:17'
               ]);
        
        DB::table('Order_Transaction')->insert([
            'id' => 2,
            'member_id' => 7,
            'item_id'=> 2,
            'item_quantity_change' => -69,
            'comment' => 'Nice',
            'transaction_date' => '2019-10-16 18:01:17'
        ]);
        
        DB::table('Order_Transaction')->insert([
            'id' => 3,
            'member_id' => 7,
            'item_id'=> 2,
            'item_quantity_change' => 69,
            'comment' => 'Nice',
            'transaction_date' => '2019-10-16 18:01:17'
        ]);
        
        DB::table('Order_Transaction')->insert([
            'id' => 4,
            'member_id' => 7,
            'item_id'=> 3,
            'item_quantity_change' => 69,
            'comment' => 'Nice',
            'transaction_date' => '2019-10-16 18:01:17'
        ]);
    }
}
