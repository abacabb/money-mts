<?php

namespace app\services\business;


use app\models\db\Limiter;
use app\models\UserWallet;
use app\models\UserWalletTransaction;

/**
 * Сервис по работе с кошельком
 *
 * Class WalletService
 * @package app\services\business
 */
class WalletService
{

    /**
     * Получить баланс кошелька
     *
     * @param UserWallet $wallet
     * @return float
     */
    public function balance(UserWallet $wallet)
    {
        $balance = 0;
        foreach ($wallet->transactions as $transaction) {
            if ($transaction->document->isCompleted()) {
                $balance += $transaction->amount;
            }
        }

        return $balance;
    }

    /**
     * Получить список транзакций по кошельку
     *
     * @param UserWallet $wallet
     * @param Limiter|null $limiter
     * @return \yii\db\ActiveRecord[]
     */
    public function transactionsHistory(UserWallet $wallet, Limiter $limiter = null)
    {
        $query = UserWalletTransaction::find()
            ->andWhere(['user_wallet_id' => $wallet->getPrimaryKey()])
            ->orderBy([
                'created_at' => SORT_DESC,
            ])
        ;
        if ($limiter) {
            $query = $limiter->bindQuery($query);
        }

        return $query->all();
    }

    public function activate(UserWallet $wallet)
    {

    }

    public function deactivate(UserWallet $wallet)
    {

    }
}