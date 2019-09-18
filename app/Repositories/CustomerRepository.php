<?php

namespace App\Repositories;

use Hyn\Tenancy\Models\Customer;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class CustomerRepository
 * @package App\Repositories
 * @version September 12, 2019, 7:41 am UTC
 *
 * @method Customer findWithoutFail($id, $columns = ['*'])
 * @method Customer find($id, $columns = ['*'])
 * @method Customer first($columns = ['*'])
*/
class CustomerRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'email'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Customer::class;
    }
}
