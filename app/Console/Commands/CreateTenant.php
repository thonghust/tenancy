<?php
namespace App\Console\Commands;
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
class CreateTenant extends Command
{
    protected $signature = 'tenant:create {name} {email}';
    protected $description = 'Creates a tenant with the provided name and email address e.g. php artisan tenant:create boise boise@example.com';
    public function handle()
    {
        $name = $this->argument('name');
        $email = $this->argument('email');
        if ($this->tenantExists($name, $email)) {
            $this->error("A tenant with name '{$name}' and/or '{$email}' already exists.");
            return;
        }
        $hostname = $this->registerTenant($name, $email);
        app(Environment::class)->hostname($hostname);
        // we'll create a random secure password for our to-be admin
        $password = str_random();
        $this->addAdmin($name, $email, $password)->notify(new TenantCreated($hostname));
        $this->info("Tenant '{$name}' đã được tạo, bạn có thể truy cập địa chỉ '{$hostname->fqdn}' ngay bây giờ.");
        $this->info("Admin {$email} đã được gửi Mail mời đổi mật khẩu.");
    }
    private function tenantExists($name, $email)
    {
        return Customer::where('name', $name)->orWhere('email', $email)->exists();
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
}