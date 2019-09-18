<?php

namespace App\Repositories;

use Hyn\Tenancy\Models\Website;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class WebsiteRepository
 * @package App\Repositories
 * @version September 12, 2019, 7:36 am UTC
 *
 * @method Website findWithoutFail($id, $columns = ['*'])
 * @method Website find($id, $columns = ['*'])
 * @method Website first($columns = ['*'])
*/
class WebsiteRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'uuid',
        'customer_id',
        'managed_by_database_connection'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Website::class;
    }
}
