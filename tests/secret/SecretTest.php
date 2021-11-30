<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;


class SecretTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */



    public function test_create_object()
    {
        $this->json('POST', '/object', [
            "json" => ["key5" => ["ba" => "jsonstring"]]
        ]);
        $output['message'] = 'New record created';
        $this->seeInDatabase('secrets',['key' => 'key5','ba' => 'jsonstring','created_at' => date('u')]);
        $this->assertJson(json_encode($output));
        $this->assertResponseStatus(201);
    }

    public function test_create_bad_json()
    {
        $this->json('POST', '/object', [
            "json" => 'abcde'
        ]);
        $output['message'] = 'Invalid json object / Only one value pair allow';
        $this->seeJson($output);
        $this->assertResponseStatus(422);
    }

    public function test_create_empty_json()
    {
        $this->json('POST', '/object', [
        ]);
        $output['message'] = 'Invalid json object / Only one value pair allow';
        $this->seeJson([
            'message' => 'The json field is required.'
         ]);
        $this->assertResponseStatus(422);
    }

    
    public function test_get_object()
    {
        $this->json('GET','/object/key1');
        $this->seeJson([
            'key1' => 1245
        ]);
        $this->assertResponseStatus(200);
    }

    public function test_get_object_with_time()
    {
        $this->json('GET','/object/key1');
        $this->seeJson([
            'key1' => 1245
        ]);
        $this->assertResponseStatus(200);
    }

    public function test_get_all()
    {
        $this->get('/object/get_all_records');
        $this->seeJsonStructure(
            [
                '*' => [
                    '*' =>
                    [
                        'value',
                        'timestamp'
                    ],
                ]
            ]
        );
        $this->assertResponseStatus(200);
    }

  
}
