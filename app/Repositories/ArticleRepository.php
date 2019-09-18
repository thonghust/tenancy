<?php

namespace App\Repositories;

use App\Article;
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
class ArticleRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'email',
        'image',
        'sumary',
        'content'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Article::class;
    }
}
