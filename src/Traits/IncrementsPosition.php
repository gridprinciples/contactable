<?php

namespace GridPrinciples\Contactable\Traits;

trait IncrementsPosition
{
    public static function bootIncrementsPosition()
    {
        self::creating(function ($model) {
            $where = $model->getAutoPositionFields();
            $model->position = $model->newQuery()->where($where)->count();
        });
    }

    public function getAutoPositionFields()
    {
        $fields = $this->autoPositionBasedOnFields;
        $return = [];

        foreach($fields as $field) {
            $return[$field] = array_get($this->attributes, $field);
        }

        return $return;
    }
}
