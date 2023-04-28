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

    public function test_it_can_register_a_new_user_with_stake_address_to_slte_site()
    {
       
        $email = "example2@gmail.com";
        $name = "example";
        $wallet_stake_address = 'stake_test1uq3v2252xzs525aeyt8kzzsp5cungukp3p9aup0493l3yws5nsafr';
        $data = ['name'=>$name, 'password'=>'mikii', 'password_confirmation'=>'mikii', 'email'=>$email, 'stake_address', 'wallet_stake_address'=>$wallet_stake_address];

        $mockRequest = Request::create('api/earn/learn/register', 'POST', $data); 
        $response = (new LearnController)->register($mockRequest);
        $user = User::where('email', $email)->first();
        
        $this->assertEquals(302, $response->status());
        $this->assertEquals(route('earn.learn.login'), $response->getTargetUrl());
        $this->assertEquals($name, $user->name);
        $this->assertTrue(($user->hasRole('learner')));
        $this->assertEquals($wallet_stake_address, $user->wallet_stake_address);
    }

    public function test_it_can_register_an_existing_user_with_stake_address_to_slte_site()
    {
        $email = "random3@gmail.com";
        $name = "random";
        $user = User::factory()->create(['name'=>$name, 'email'=>$email, 'wallet_stake_address'=>'stake_test1uq3v2252xzs525aeyt8kzzsp5cungukp3p9aup0493l3yws5nsafr']);
        
        $newStakeAddress = 'stake_test1uq3v2252xzs525aeyt8kzzsp5cungukp3p9aup0493l3yws5newstake';
        $data = ['name'=>$name, 'password'=>'password', 'password_confirmation'=>'password', 'email'=>$email, 'wallet_stake_address'=>$newStakeAddress];
        $this->assertFalse($user->hasRole('learner'));

        $mockRequest = Request::create('api/earn/learn/register', 'POST', $data); 
        $response = (new LearnController)->register($mockRequest);
        $this->assertEquals(302, $response->status());
        
        $user = User::where('email', $email)->first();
        $this->assertEquals($newStakeAddress, $user->wallet_stake_address);  //asserts that the user wallet stake address was updated
        $this->assertTrue($user->hasRole('learner'));
    }
}