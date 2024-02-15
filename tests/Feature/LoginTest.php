<?php
namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;

class LoginTest extends ExampleTest
{
    public function testRegistration()
    {
        // refresh database
        $request = $this->post('/api/register',
            [
                "name"=>"TestUser",
                "email"=>"testuser@gmail.com",
                "password"=>"123"
            ]
        );

        $this->assertEquals(201,$request->getStatusCode());

        $response_data = json_decode($request->getContent(),true);
        $this->assertArrayHasKey("user",$response_data);
    }

    public function testSuccessfulLogin()
    {
        $request = $this->post('/api/login',
            [
                "email"=>"testuser@gmail.com",
                "password"=>"123"
            ]
        );
        $this->assertEquals(200,$request->getStatusCode());
    }

    public function testFailedLogin()
    {
        $request = $this->post('/api/login',
            [
                "email"=>"testuser@gmail.com",
                "password"=>"1234"
            ]
        );
        $this->assertEquals(401,$request->getStatusCode());
        $response = $request->getContent();
        $this->assertEquals($response,'{"message":"Invalid credential"}');
    }
}
