<?php

namespace Tests\Unit;

use App\Http\Controllers\TransactionsController;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TransactionsControllerTest extends TestCase
{
    use RefreshDatabase;
    /**
     * Shouldn't need a test for editing transactions
     */
//    public function testEdit()
//    {}

    /** Shouldn't need a test for destroy since transactions should be immutable. */
//    public function testDestroy()
//    {}

//    public function testIndex()
//    {}

//    public function testCreate()
//    {}

    /**
     * Test to show that we can store new transactions for items.
     */
    public function testStore()
    {
        // Test a good request
        $this->withoutMiddleware();
        $response = $this->json('POST', 'transactions',
            [
                'item_id' => '1',
                'user_id' => '1',
                'quantity_change' => '10',
                'comment' => 'Yeet',
            ]);
        // evaluate
        $response
            ->assertStatus(200)
            ->assertJson([
                'status' => 'transaction succeeded',
                'transaction_change' => '10',
                'transaction_user' => '1',
                'comment' => 'Yeet'
            ]);

        // Test a good request without the transaction comment
        $this->withoutMiddleware();
        $response = $this->json('POST', 'transactions',
            [
                'item_id' => '1',
                'user_id' => '1',
                'quantity_change' => '10',
            ]);
        // evaluate
        $response
            ->assertStatus(200)
            ->assertJson([
                'status' => 'transaction succeeded',
                'transaction_change' => '10',
                'transaction_user' => '1',
            ]);

        // test a bad request
        $this->withoutMiddleware();
        $response = $this->json('POST', 'transactions',
            [
                'item_id' => '1',
                'quantity_change' => '10',
                'comment' => 'Yeet',
            ]);
        // evaluate
        $response
            ->assertStatus(422)
            ->assertJson([
                'message' => 'The given data was invalid.',
                'errors' => [
                    'refrigerated' => ['The refrigerated field is required.']
                ]
            ]);
    }

    /**
     * Test the show function to get the transactions that we need.
     */
//    public function testShow()
//    {}

    /**
     * No testing needed for updating because transactions should be immutable.
     */
//    public function testUpdate()
//    {}
}
