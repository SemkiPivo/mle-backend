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

    public function test_successful_code_sending(): void
    {
        $data = [
            'subject' => 'test@example.com'
        ];

        $response = $this->postJson('/api/auth/code/send',$data);
        $response->assertStatus(200);
    }

    public function test_successful_code_confirmation(): void
    {
        $sentData = $this->postJson('/api/auth/code/send',['subject' => 'test@example.com'])->json()['data']['code'];

        $data = [
            'subject' => $sentData['confirmation_subject'],
            'code' => $sentData['code']
        ];

        $response = $this->postJson('/api/auth/code/confirm',$data);
        $response->assertStatus(200);
    }
    public function test_successful_password_restoration(): void
    {
//        dd($this->postJson('/api/auth/code/send',['subject' => $this->user->email])->json());
        $sentData = $this->postJson('/api/auth/code/send',['subject' => $this->user->email])->json()['data']['code'];

        $data = [
            'email' => $this->user->email,
            'code' => $sentData['code'],
            'password' => '654321',
            'password_confirmation' => '654321'
        ];


        $response = $this->postJson('api/auth/forgot',$data);
//        dd($response->json());
        $response->assertStatus(200);
    }
}
