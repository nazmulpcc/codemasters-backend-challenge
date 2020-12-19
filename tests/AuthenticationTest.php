<?php

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class AuthenticationTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testLogin()
    {
        $admin = $this->getAdmin();

        $this->post('/auth/login', [
            'email' => $admin->email,
            'password' => 'secret'
        ]);

        $this->assertEquals(
            true, $this->response->json('success')
        );
    }

    public function testRegistration()
    {
        $this->be($this->getAdmin());

        $email = 'adminnew@admin.com';
        $this->post('/auth/register', [
            'name' => 'Another Admin',
            'email' => $email,
            'password' => Hash::make('secret')
        ]);

        $this->assertResponseOk();

        $admin = User::where('email', $email)->first();
        $this->assertEquals(
            $email, $admin->email
        );
    }
}
