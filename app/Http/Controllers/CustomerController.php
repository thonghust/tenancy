<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateCustomerRequest;
use App\Http\Requests\UpdateCustomerRequest;
use App\Repositories\CustomerRepository as InfyomCustomerRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use App\User;
use Hyn\Tenancy\Contracts\Repositories\CustomerRepository;
use Hyn\Tenancy\Contracts\Repositories\HostnameRepository;
use Hyn\Tenancy\Contracts\Repositories\WebsiteRepository;
use Hyn\Tenancy\Environment;
use Hyn\Tenancy\Models\Customer;
use Hyn\Tenancy\Models\Hostname;
use Hyn\Tenancy\Models\Website;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use App\Notifications\TenantCreated;

class CustomerController extends AppBaseController
{
    /** @var  CustomerRepository */
    private $customerRepository;

    public function __construct(InfyomCustomerRepository $customerRepo)
    {
        $this->customerRepository = $customerRepo;
    }

    /**
     * Display a listing of the Customer.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->customerRepository->pushCriteria(new RequestCriteria($request));
        $customers = $this->customerRepository->all();

        return view('customers.index')
        ->with('customers', $customers);
    }

    /**
     * Show the form for creating a new Customer.
     *
     * @return Response
     */
    public function create()
    {
        return view('customers.create');
    }

    /**
     * Store a newly created Customer in storage.
     *
     * @param CreateCustomerRequest $request
     *
     * @return Response
     */
    public function store(CreateCustomerRequest $request)
    {
        $input = $request->all();
        $name = $input['name'];
        $email = $input['email'];
        $hostname = $this->registerTenant($name, $email);
        app(Environment::class)->hostname($hostname);
        $password = str_random();
        $addAdmin = $this->addAdmin($name, $email, $password);
        $addAdmin->notify(new TenantCreated($hostname, $password));

        Flash::success('Customer saved successfully.');

        return redirect(route('customers.index'));
    }

    private function registerTenant($name, $email)
    {
        // create a customer
        $customer = new Customer;
        $customer->name = $name;
        $customer->email = $email;
        app(CustomerRepository::class)->create($customer);
        // associate the customer with a website
        $website = new Website;
        $website->customer()->associate($customer);
        app(WebsiteRepository::class)->create($website);
        // associate the website with a hostname
        $hostname = new Hostname;
        $baseUrl = config('app.url_base');
        $hostname->fqdn = "{$name}.{$baseUrl}";
        $hostname->customer()->associate($customer);
        app(HostnameRepository::class)->attach($hostname, $website);
        return $hostname;
    }

    private function addAdmin($name, $email, $password)
    {
        $admin = User::create(['name' => $name, 'email' => $email, 'password' => Hash::make($password)]);
        $admin->guard_name = 'web';
        $admin->assignRole('admin');
        return $admin;
    }

    /**
     * Display the specified Customer.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $customer = $this->customerRepository->findWithoutFail($id);

        if (empty($customer)) {
            Flash::error('Customer not found');

            return redirect(route('customers.index'));
        }

        return view('customers.show')->with('customer', $customer);
    }

    /**
     * Show the form for editing the specified Customer.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $customer = $this->customerRepository->findWithoutFail($id);

        if (empty($customer)) {
            Flash::error('Customer not found');

            return redirect(route('customers.index'));
        }

        return view('customers.edit')->with('customer', $customer);
    }

    /**
     * Update the specified Customer in storage.
     *
     * @param  int              $id
     * @param UpdateCustomerRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateCustomerRequest $request)
    {
        $customer = $this->customerRepository->findWithoutFail($id);

        if (empty($customer)) {
            Flash::error('Customer not found');

            return redirect(route('customers.index'));
        }

        $customer = $this->customerRepository->update($request->all(), $id);

        Flash::success('Customer updated successfully.');

        return redirect(route('customers.index'));
    }

    /**
     * Remove the specified Customer from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $customer = Customer::where('id', $id)->with(['websites', 'hostnames'])->firstOrFail();
        $hostname = $customer->hostnames->first();
        $website = $customer->websites->first();
        app(HostnameRepository::class)->delete($hostname, true);
        app(WebsiteRepository::class)->delete($website, true);
        app(CustomerRepository::class)->delete($customer, true);

        Flash::success('Hostname deleted successfully.');

        return redirect(route('customers.index'));
    }
}
