<?php

namespace app\models\db;

/**
 * Class ActiveRecord
 * @package app\models\db
 */
abstract class ActiveRecord extends \yii\db\ActiveRecord
{
    public static function findOneOrFail($condition)
    {
       $object = static::findOne($condition);
       if (null === $object) {
           throw new \Exception(sprintf('Entity "%s" not found', get_called_class()));
       }

       return $object;
    }
}