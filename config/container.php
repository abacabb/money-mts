<?php

$container = \Yii::$container;

$container->set('document_service', \app\services\business\DocumentService::class);
$container->set('currency_service', \app\services\business\CurrencyService::class);
$container->set('wallet_service', \app\services\business\WalletService::class);
$container->set(\app\models\document\OperationsFactory::class, function () use ($container) {
    return new \app\models\document\OperationsFactory($container);
});
$container->set(\app\models\document\operations\TransferWalletToWallet::class);
$container->set(\app\models\document\operations\AddFundsToWallet::class);