<?php

namespace app\models;


use yii\db\ActiveRecord;

/**
 * Системный кошелек
 *
 * Class Wallet
 * @package app\models
 *
 * @property $id
 * @property $currency_id
 * @property $name название кошелька
 *
 * @property Currency $currency;
 */
class SystemWallet extends ActiveRecord
{
    public function getCurrency()
    {
        return $this->hasOne(Currency::class, ['id' => 'currency_id']);
    }
}