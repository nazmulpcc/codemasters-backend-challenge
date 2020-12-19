<?php

use App\Models\Customer;
use App\Models\Room;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Laravel\Lumen\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    /**
     * Creates the application.
     *
     * @return \Laravel\Lumen\Application
     */
    public function createApplication()
    {
        return require __DIR__.'/../bootstrap/app.php';
    }

    /**
     * @return User
     */
    public function getAdmin()
    {
        return User::firstOrCreate([
            'email' => 'admin@admin.com'
        ], [
            'name' => 'Admin',
            'password' => Hash::make('secret')
        ]);
    }

    public function login(User $admin)
    {
        $this->actingAs($admin);
    }

    /**
     * @return Room
     */
    public function createRoom()
    {
        return Room::firstOrCreate([
            'room_number' => 100
        ], [
            'max_persons' => 5,
            'room_type'   => 'general',
            'price'       => 1000
        ]);
    }

    public function createCustomer()
    {
        return Customer::firstOrCreate([
            'email'      => 'test@user.com',
        ], [
            'first_name' => 'test',
            'last_name'  => 'test',
            'phone'      => '01700000000'
        ]);
    }
}
