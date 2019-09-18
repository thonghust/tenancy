<?php

namespace Hyn\Tenancy\Models;

use Illuminate\Database\Eloquent\Model as Model;
use Carbon\Carbon;
use Hyn\Tenancy\Abstracts\SystemModel;
use Hyn\Tenancy\Contracts\Website as WebsiteContract;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Hyn\Tenancy\Traits\UsesSystemConnection;

class Website extends Model implements WebsiteContract
{
	use UsesSystemConnection;
	
	public $table = 'websites';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    public $fillable = [
        'uuid',
        'customer_id',
        'managed_by_database_connection'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'uuid' => 'string',
        'customer_id' => 'integer',
        'managed_by_database_connection' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'id' => 'required',
        'uuid' => 'required'
    ];
    public function customer(): BelongsTo
    {
        return $this->belongsTo(config('tenancy.models.customer'));
    }

    public function hostnames(): HasMany
    {
        return $this->hasMany(config('tenancy.models.hostname'));
    }
}
