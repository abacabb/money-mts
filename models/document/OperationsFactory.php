<?php

namespace app\models\document;


use app\models\document\operations\AddFundsToWallet;
use app\models\document\operations\TransferWalletToWallet;
use yii\di\Container;

/**
 * Создает операцию, которая исполнит документ
 *
 * Class OperationsFactory
 * @package app\models\document
 */
class OperationsFactory
{
    private $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    public function create($type)
    {
        switch ($type) {
            case TransferWalletToWallet::class:
                return $this->container->get(TransferWalletToWallet::class);
            case AddFundsToWallet::class:
                return $this->container->get(AddFundsToWallet::class);
        }

        throw new \InvalidArgumentException('Operation type not found');
    }
}