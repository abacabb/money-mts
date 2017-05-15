<?php

namespace app\models;


use app\models\db\ActiveRecord;

/**
 * Кошелек пользователя
 *
 * Class UserWallet
 * @package app\models
 *
 * @property $id
 * @property $user_id
 * @property $wallet_id
 *
 * @property SystemWallet $systemWallet
 * @property User $user
 * @property UserWalletTransaction[] $transactions
 */
class UserWallet extends ActiveRecord
{
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    public function getSystemWallet()
    {
        return $this->hasOne(SystemWallet::class, ['id' => 'wallet_id']);
    }

    public function getTransactions()
    {
        return $this->hasMany(UserWalletTransaction::class, ['user_wallet_id' => 'id']);
    }
}