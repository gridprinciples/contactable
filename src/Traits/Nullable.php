<?php

/**
 * This trait will set empty fields defined in the $nullable array as NULL on save.
 */

namespace GridPrinciples\Party\Traits;

trait Nullable
{
    protected $nullable = [];

    protected static function bootNullable()
    {
        static::saving(function ($model) {
            // Listen for save event.
            $model->setNullable();
        });
    }

    /**
     * Set empty nullable fields to null.
     */
    protected function setNullables()
    {
        foreach ($this->nullable as $field) {
            if (empty($this->{$field})) {
                $this->{$field} = null;
            }
        }
    }
}
