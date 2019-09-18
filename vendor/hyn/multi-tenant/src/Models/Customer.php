<?php

/*
 * This file is part of the hyn/multi-tenant package.
 *
 * (c) Daniël Klabbers <daniel@klabbers.email>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @see https://laravel-tenancy.com
 * @see https://github.com/hyn/multi-tenant
 */

namespace Hyn\Tenancy\Models;

use Carbon\Carbon;
use Hyn\Tenancy\Abstracts\SystemModel;
use Hyn\Tenancy\Contracts\Customer as CustomerContract;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model as Model;
use Hyn\Tenancy\Traits\UsesSystemConnection;

class Customer extends Model implements CustomerContract
{
	use UsesSystemConnection;
	
	public $table = 'customers';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    public $fillable = [
        'name',
        'email'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'email' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required',
        'email' => 'required'
    ];
    public function websites(): HasMany
    {
        return $this->hasMany(config('tenancy.models.website'));
    }

    public function hostnames(): HasMany
    {
        return $this->hasMany(config('tenancy.models.hostname'));
    }
}
