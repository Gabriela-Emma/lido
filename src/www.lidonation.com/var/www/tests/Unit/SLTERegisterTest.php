<?php

namespace Tests\Unit;

use App\Models\User;
use App\Http\Controllers\Earn\LearnController;
use Illuminate\Http\Request;
use Tests\TestCase;

class SLTERegisterTest extends TestCase
{
    
    public function test_it_can_register_a_new_user_to_slte_site()
    {
       
        $email = "example1@gmail.com";
        $name = "example";
        $data = ['name'=>$name, 'password'=>'mikii', 'password_confirmation'=>'mikii', 'email'=>$email];

        $mockRequest = Request::create('api/earn/learn/register', 'POST', $data); 
        $response = (new LearnController)->register($mockRequest);
        $user = User::where('email', $email)->first();
        
        $this->assertEquals(302, $response->status());
        $this->assertEquals(route('earn.learn.login'), $response->getTargetUrl());
        $this->assertEquals($name, $user->name);
        $this->assertTrue(($user->hasRole('learner')));
    }

    public function test_it_can_register_an_existing_user_to_slte_site()
    {
        $email = "random1@gmail.com";
        $name = "random";
        $user = User::factory()->create(['name'=>$name, 'email'=>$email]);
        $data = ['name'=>$name, 'password'=>'password', 'password_confirmation'=>'password', 'email'=>$email];
        $this->assertFalse($user->hasRole('learner'));

        $mockRequest = Request::create('api/earn/learn/register', 'POST', $data); 
        $response = (new LearnController)->register($mockRequest);
        $this->assertEquals(302, $response->status());
        
        $user = User::where('email', $email)->first();
        $this->assertTrue($user->hasRole('learner'));
    }
}