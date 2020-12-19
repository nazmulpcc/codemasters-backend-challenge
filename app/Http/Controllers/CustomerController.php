<?php


namespace App\Http\Controllers;


use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * List Customers
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $customers = Customer::latest()
            ->paginate($request->input('limit', 10));

        return $this->success($customers);
    }

    /**
     * Show Single Customer
     * @param $customer
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($customer, Request $request)
    {
        $customer = Customer::findOrFail($customer);
        $customer->load(['bookings']);

        return $this->success($customer);
    }

    /**
     * Add a new Customer
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $data = $this->validate($request, [
            'first_name' => 'required|string|max:100',
            'last_name'  => 'required|string|max:100',
            'email'      => 'required|string|unique:customers',
            'phone'      => 'required|string|min:11|max:14|unique:customers',
        ]);

        $customer = Customer::create($data);

        return $this->success($customer);
    }

    /**
     * Update Customer
     * @param $customer
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update($customer, Request $request)
    {
        $data = $this->validate($request, [
            'first_name' => 'required|string|max:100',
            'last_name'  => 'required|string|max:100',
            'email'      => 'required|string|unique:customers,email,'. $customer,
            'phone'      => 'required|string|min:11|max:14|unique:customers,phone,'. $customer,
        ]);

        $customer = Customer::findOrFail($customer);
        $customer->update($data);

        return $this->success($customer);
    }
}
