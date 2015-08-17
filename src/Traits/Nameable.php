<?php

/**
 * This trait allows you to always be able to call $model->name on any given model.
 * Allows any field to be considered the model's name.
 */

namespace GridPrinciples\Party\Traits;

trait Nameable
{
    /**
     * Common mutator for the name field. Set $this->nameField to the model key you wish to use as the `name`.
     *
     * @return string
     */
    public function getNameAttribute()
    {
        if ($this->getNameField() == 'name') {
            // Already being mutated as "name", so prevent a loop...
            return array_get($this->attributes, 'name');
        }

        return $this->getAttribute($this->getNameField());
    }

    /**
     * Allows setting the model's "name" even if the model really uses a different field.
     *
     * @param $value
     */
    public function setNameAttribute($value)
    {
        if ($this->getNameField() == 'name') {
            // Already being accessed as "name", so prevent a loop...
            $this->attributes[$this->getNameField()] = $value;
        } else {
            $this->setAttribute($this->getNameField(), $value);
        }
    }

    /**
     * Gets the model-specific default name field.
     * @return string
     */
    protected function getNameField()
    {
        return isset($this->nameField) && $this->nameField ? $this->nameField : 'name';
    }
}
