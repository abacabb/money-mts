<?php

namespace app\services\business;


use app\models\document\Document;
use app\models\document\operations\AddFundsToWallet;
use app\models\document\OperationsFactory;
use app\models\document\operations\TransferWalletToWallet;
use app\services\business\dto\AddFundsDto;
use app\services\business\dto\TransferDto;

/**
 * Сервис по работе с документами.
 * Почему поплнения кошелька находится в данном сервисе, а не в WalletService?
 * Т.к. работа с балансом кошелька - это работа с документами, транзакциями и т.д.
 *
 * Class DocumentService
 * @package app\services\business
 */
class DocumentService
{
    private $factory;

    public function __construct(OperationsFactory $factory)
    {
        $this->factory = $factory;
    }

    /**
     * @param TransferDto $dto
     * @return Document
     */
    public function transfer(TransferDto $dto)
    {
        $document = Document::create();
        /** @var TransferWalletToWallet $operation */
        $operation = $this->factory->create(TransferWalletToWallet::class);
        $operation->setDto($dto);
        $document->setOperation($operation);
        $document->save();

        $document->forward();
        $document->setAsCompleted();
        $document->save();

        return $document;
    }

    /**
     * @param AddFundsDto $dto
     * @return Document
     */
    public function addFunds(AddFundsDto $dto)
    {
        $document = Document::create();
        /** @var AddFundsToWallet $operation */
        $operation = $this->factory->create(AddFundsToWallet::class);
        $operation->setDto($dto);
        $document->setOperation($operation);
        // такой вот костыль, что бы получить ПК, была бы доктрина с ее графом зависимостей...
        $document->save();

        $document->forward();
        $document->setAsCompleted();
        $document->save();

        return $document;
    }
}