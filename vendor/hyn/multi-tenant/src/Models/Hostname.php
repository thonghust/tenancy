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

use Illuminate\Database\Eloquent\Model as Model;
use Carbon\Carbon;
use Hyn\Tenancy\Abstracts\SystemModel;
use Hyn\Tenancy\Contracts\Hostname as HostnameContract;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Hyn\Tenancy\Traits\UsesSystemConnection;

class Hostname extends Model implements HostnameContract
{
	use UsesSystemConnection;
	
	public $table = 'hostnames';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';



    public $fillable = [
        'fqdn',
        'redirect_to',
        'force_https',
        'under_maintenance_since',
        'website_id',
        'customer_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'fqdn' => 'string',
        'redirect_to' => 'string',
        'force_https' => 'boolean',
        'under_maintenance_since' => 'datetime',
        'website_id' => 'integer',
        'customer_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'id' => 'required',
        'fqdn' => 'required',
        'force_https' => 'required'
    ];

    protected $dates = ['under_maintenance_since'];

    public function website(): BelongsTo
    {
        return $this->belongsTo(config('tenancy.models.website'));
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(config('tenancy.models.customer'));
    }
}
