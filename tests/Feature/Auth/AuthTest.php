<?php

namespace Auth;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    private $user;
    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
    }

    public function test_successful_registration(): void
    {
        $password = Hash::make(\Str::password(8));
        $data = [
            'name' => fake()->name(),
            'email' => fake()->email(),
            'phone' => fake()->phoneNumber(),
            'password' => $password,
            'birthday' => Carbon::now(),
            'gender' => 'male',
            'is_notifiable' => true,
//            'location_id' => Location::first()->id,
            'password_confirmation' => $password,
        ];


        $response = $this->postJson('/api/auth/register',$data);
        $response->assertStatus(200);
    }

    public function test_successful_login(): void
    {
        $data = [
            "email" => $this->user->email,
            "password" => '123456',
        ];

        $response = $this->postJson('/api/auth/login',$data);
        $response->assertStatus(200);
    }

//    public function test_successful_code_sending(): void
//    {
//        $data = [
//            'subject' => 'example'
//        ];
//
//        $response = $this->postJson('/api/auth/code/send',$data);
//        dd($response->json());
//        $response->assertStatus(200);
//    }
}
