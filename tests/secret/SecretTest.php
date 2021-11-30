<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use App\Models\Secret;


class SecretTest extends TestCase
{
    use DatabaseMigrations;

    public function test_create_object()
    {
        $this->json('POST', '/object', [
            "json" => ['key1' => ['akey' => '1ab']]
        ]);
        $output['message'] = 'New record created';
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
        Secret::factory()->keyvalue('key12',['first'=>'hi'])->create();
        Secret::factory()->keyvalue('key12',['second'=>'hi'])->create();
        $this->json('GET','/object/key12');
        $this->seeJson([
            'key12' => ['second' => 'hi']
        ]);
        $this->assertResponseStatus(200);
    }

    public function test_get_object_with_time()
    {
        Secret::factory()->keytime(['me'=>'third'],'111232311')->create();
        Secret::factory()->keytime(['me'=>'first'],'222222222')->create();
        Secret::factory()->keytime(['me'=>'last'],'332343243')->create();

        $this->json('GET','/object/mykey?timestamp=222222222');
        $this->seeJson([
            'mykey' => ['me'=>'first']
        ]);
        $this->assertResponseStatus(200);
    }

    public function test_get_object_with_invalid_time(){

        $this->json('GET','/object/mykey?timestamp=0');
        $this->seeJson([
            'message' => 'timestamp need to be in Unix format'
        ]);
        $this->assertResponseStatus(422);

    }

    public function test_get_all()
    {
        Secret::factory()->count(3)->keyone()->create();
        Secret::factory()->count(3)->create();
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
