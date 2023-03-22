<?php

namespace FluentPlugin\Framework\Database\Orm;

interface Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     *
     * @param  \FluentPlugin\Framework\Database\Orm\Builder  $builder
     * @param  \FluentPlugin\Framework\Database\Orm\Model  $model
     * @return void
     */
    public function apply(Builder $builder, Model $model);
}
