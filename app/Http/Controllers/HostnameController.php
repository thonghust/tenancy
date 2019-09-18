<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateCustomerRequest;
use App\Http\Requests\UpdateCustomerRequest;
use App\Repositories\HostnameRepository as InfyomHostnameRepository;
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

class HostnameController extends AppBaseController
{
    /** @var  HostnameRepository */
    private $hostnameRepository;

    public function __construct(InfyomHostnameRepository $hostnameRepo)
    {
        $this->hostnameRepository = $hostnameRepo;
    }

    /**
     * Display a listing of the Hostname.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->hostnameRepository->pushCriteria(new RequestCriteria($request));
        $hostnames = $this->hostnameRepository->all();

        return view('hostnames.index')
            ->with('hostnames', $hostnames);
    }

    /**
     * Show the form for creating a new Hostname.
     *
     * @return Response
     */
    public function create()
    {
        return view('customers.create');
    }

    /**
     * Store a newly created Hostname in storage.
     *
     * @param CreateHostnameRequest $request
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
        $this->addAdmin($name, $email, $password)->notify(new TenantCreated($hostname));

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
     * Display the specified Hostname.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $hostname = $this->hostnameRepository->findWithoutFail($id);

        if (empty($hostname)) {
            Flash::error('Hostname not found');

            return redirect(route('hostnames.index'));
        }

        return view('hostnames.show')->with('hostname', $hostname);
    }

    /**
     * Show the form for editing the specified Hostname.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $hostname = $this->hostnameRepository->findWithoutFail($id);

        if (empty($hostname)) {
            Flash::error('Hostname not found');

            return redirect(route('hostnames.index'));
        }

        return view('hostnames.edit')->with('hostname', $hostname);
    }

    /**
     * Update the specified Hostname in storage.
     *
     * @param  int              $id
     * @param UpdateHostnameRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateHostnameRequest $request)
    {
        $hostname = $this->hostnameRepository->findWithoutFail($id);

        if (empty($hostname)) {
            Flash::error('Hostname not found');

            return redirect(route('hostnames.index'));
        }

        $hostname = $this->hostnameRepository->update($request->all(), $id);

        Flash::success('Hostname updated successfully.');

        return redirect(route('hostnames.index'));
    }

    /**
     * Remove the specified Hostname from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $hostname = $this->hostnameRepository->findWithoutFail($id);

        if (empty($hostname)) {
            Flash::error('Hostname not found');

            return redirect(route('hostnames.index'));
        }

        $this->hostnameRepository->delete($id);

        Flash::success('Hostname deleted successfully.');

        return redirect(route('hostnames.index'));
    }
}
