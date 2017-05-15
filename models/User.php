<?php

namespace app\models;
use app\models\db\ActiveRecord;


/**
 * Class User
 * @package app\models
 *
 * @property $id;
 * @property $name;
 *
 * @property UserWallet[] $wallets
 */
class User extends ActiveRecord
{
    public function getWallets()
    {
        return $this->hasMany(UserWallet::class, ['user_id' => 'id']);
    }
}