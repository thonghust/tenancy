<?php

namespace App\Repositories;

use Hyn\Tenancy\Models\Hostname;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class HostnameRepository
 * @package App\Repositories
 * @version September 12, 2019, 7:47 am UTC
 *
 * @method Hostname findWithoutFail($id, $columns = ['*'])
 * @method Hostname find($id, $columns = ['*'])
 * @method Hostname first($columns = ['*'])
*/
class HostnameRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'fqdn',
        'redirect_to',
        'force_https',
        'under_maintenance_since',
        'website_id',
        'customer_id'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Hostname::class;
    }
}
