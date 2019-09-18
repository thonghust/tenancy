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

namespace Hyn\Tenancy\Abstracts;

use Hyn\Tenancy\Database\Connection;
use Hyn\Tenancy\Exceptions\ModelValidationException;
use Illuminate\Contracts\Validation\Factory;
use Illuminate\Validation\Validator as Native;
use Illuminate\Database\Eloquent\Model as ModelBase;

abstract class Validator
{
    /**
     * @var array
     */
    protected $create = [];
    /**
     * @var array
     */
    protected $update = [];
    /**
     * @var array
     */
    protected $delete = [];

    /**
     * @param AbstractModel $model
     * @return bool
     */
    public function save(ModelBase $model): bool
    {
        if ($model->exists) {
            return $this->update($model);
        }

        return $this->create($model);
    }

    /**
     * @param AbstractModel $model
     * @return bool
     */
    public function delete(ModelBase $model)
    {
        return $this->validate(
            $model,
            $this->delete
        );
    }

    /**
     * @param AbstractModel $model
     * @return bool
     */
    protected function update(ModelBase $model)
    {
        return $this->validate(
            $model,
            $this->update
        );
    }

    /**
     * @param AbstractModel $model
     * @return bool
     */
    protected function create(ModelBase $model)
    {
        return $this->validate(
            $model,
            $this->create
        );
    }

    /**
     * @param AbstractModel $model
     * @param array $rules
     * @return bool
     * @throws ModelValidationException
     */
    protected function validate(ModelBase $model, array $rules)
    {
        /** @var Factory $validator */
        $factory = app(Factory::class);

        $rules = $this->replaceVariables($rules, $model);

        /** @var Native $validator */
        $validator = $factory->make(
            $model->getAttributes(),
            $rules
        );

        if ($validator->fails()) {
            throw new ModelValidationException($validator);
        }

        return $validator->passes();
    }

    /**
     * @param array $rules
     * @param AbstractModel $model
     * @return array
     */
    protected function replaceVariables(array $rules, ModelBase $model)
    {
        /** @var Connection $connection */
        $connection = app(Connection::class);

        return collect($rules)->map(function ($ruleSet) use ($connection, $model) {
            return collect($ruleSet)->map(function ($rule) use ($connection, $model) {
                return str_replace([
                    '%system%',
                    '%tenant%',
                    '%id%'
                ], [
                    $connection->systemName(),
                    $connection->tenantName(),
                    $model->id
                ], $rule);
            })->toArray();
        })->toArray();
    }
}
