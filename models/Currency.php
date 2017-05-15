<?php

namespace app\models;


use app\models\db\ActiveRecord;

/**
 * Валюта
 * ratio - индекс преобразования между валютами, относительно абстрактной базоваой валюты
 * ratio абстрактной базавой валюты равен 1
 *
 * Class Currency
 * @package app\models
 *
 * @property $id;
 * @property $name название валюты
 * @property $ratio
 */
class Currency extends ActiveRecord
{
    public static function createBase()
    {
        $currency = new static();
        $currency->name = 'BASE';
        $currency->ratio = 1;

        return $currency;
    }
}