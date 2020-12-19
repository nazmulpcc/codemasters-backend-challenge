<?php


use Laravel\Lumen\Testing\DatabaseMigrations;

class CustomerTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @var \App\Models\Customer
     */
    protected $customer;

    protected function setUp(): void
    {
        parent::setUp();
        $this->customer = $this->createCustomer();
        $this->be($this->getAdmin());
    }

    public function testIndexApi()
    {
        $this->get('customers');

        $this->assertResponseOk();
        $this->assertEquals(1, $this->response->json('total'));
    }

    public function testCreateApi()
    {
        $email = 'test2@user.com';
        $this->post('/customers', [
            'first_name' => 'test',
            'last_name'  => 'test',
            'email'      => $email,
            'phone'      => '01777777777'
        ]);

        $this->assertResponseOk();
        $this->seeInDatabase('customers', compact('email'));
    }

    public function testUpdateApi()
    {
        $email = 'test3@user.com';
        $data = array_merge(compact('email'), $this->customer->only([
            'first_name', 'last_name', 'phone'
        ]));
        $this->post("/customers/{$this->customer->id}", $data);

        $this->assertResponseOk();
        $this->seeInDatabase('customers', compact('email'));
    }

    public function testShowApi()
    {
        $this->get("/customers/{$this->customer->id}");

        $this->assertResponseOk();
        $this->assertEquals(
            $this->customer->email, $this->response->json('data.email')
        );
    }
}
