<?php

namespace Tests\Unit;

use App\Http\Controllers\ItemsController;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class ItemsControllerTest extends TestCase
{
    // By using this, we will rollback the db transaction to avoid polluting the db with test cases
//    use RefreshDatabase;
    use WithoutMiddleware;

    /**
     * Testing the store function in the ItemsController. Need to validate that it does actually update the
     * database.
     */
    public function testStore()
    {
        // Test a good request
        $this->withoutMiddleware();
        $response = $this->json('POST', 'items',
            ['name' => 'Yeeterinos',
                'capacity' => '420',
                'threshold' => '42',
                'isFood' => 'true',
                'refrigerated' => 'false'
            ]);
        // evaluate
        $response
            ->assertStatus(200)
            ->assertJson([
                'status' => 'item created',
                'item_name' => 'Yeeterinos'
            ]);

        // test a bad request
        $this->withoutMiddleware();
        $response = $this->json('POST', 'items',
            ['name' => 'Yeeterinos',
                'capacity' => '420',
                'threshold' => '42',
                'isFood' => 'true',
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

    public function testUpdate()
    {
        $this->withoutMiddleware();

        // Test just modifying the item
        $response = $this->json('PUT', 'items/1',
            ['id' => '1',
                'name' => 'Yeeterinos',
                'capacity' => '100',
                'threshold' => '10',
                'isFood' => 'false',
                'refrigerated' => 'false',
                'removed' => 'false'
            ]);
        // evaluate
        $response
            ->assertStatus(200)
            ->assertJson([
                'status' => 'item modified',
                'item_name' => 'Yeeterinos',
                'item_capacity' =>  '100',
                'item_threshold' => '10',
                'item_is_food' => 'false',
                'item_refrigerated' => 'false'
            ]);

        // Test Removing an item by setting the removed field to True
        $response = $this->json('PUT', 'items/1',
            ['name' => 'Yeeterinos',
                'capacity' => '420',
                'threshold' => '42',
                'isFood' => 'true',
                'refrigerated' => 'true',
                'removed' => 'true'
            ]);
        // evaluate
        $response
            ->assertStatus(200)
            ->assertJson([
                'status' => 'item removed',
                'item_id' => '1',
                'item_name' => 'Yeeterinos',
                'item_removed' => 'true'
            ]);

        // test a bad request
        $this->withoutMiddleware();
        $response = $this->json('PUT', 'items/1',
            ['name' => 'Yeeterinos',
                'capacity' => '420',
                'isFood' => 'true',
            ]);
        // evaluate
        $response
            ->assertStatus(422)
            ->assertJson([
                'message' => 'The given data was invalid.',
                'errors' => [
                    'threshold' => ['The threshold field is required.']
                ]
            ]);
    }

//    public function testCreate()
//    {
//        //
//    }
//
//    public function testShow()
//    {
////        $response = $this->json('GET', 'items/1');
////
////        echo ($response.$this->toString());
//
//
//    }
//
//    public function testEdit()
//    {
//        //
//    }
//
//    public function testIndex()
//    {
//        //
//    }
//
//    public function testDestroy()
//    {
//        //
//    }
}
