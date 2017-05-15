<?php

namespace app\models\document\operations;


use app\models\Currency;
use app\models\document\Document;
use app\models\document\DocumentOperationInterface;
use app\models\UserWallet;
use app\models\UserWalletTransaction;
use app\services\business\CurrencyService;
use app\services\business\dto\AddFundsDto;
use app\services\business\exceptions\CurrencyNotFoundException;
use app\services\business\exceptions\UserWalletNotFoundException;

/**
 * Пополнить счет кошелька
 *
 * Class AddFundsToWallet
 * @package app\models\document\operations
 */
class AddFundsToWallet extends AbstractDTOedDocumentOperation implements DocumentOperationInterface
{
    private $currencyService;

    public function __construct(CurrencyService $currencyService)
    {
        $this->currencyService = $currencyService;
    }

    public function forward(Document $document)
    {
        $this->validateDocument($document);

        /** @var AddFundsDto $dto */
        $dto = $this->getDto();
        $targetWallet = UserWallet::findOne($dto->getTargetWalletId());
        $this->validateWallet($targetWallet);

        $sourceCurrency = $this->getSourceCurrency($dto);
        $targetAmount = $this->currencyService->exchange(
            $dto->getAmount(),
            $sourceCurrency,
            $targetWallet->systemWallet->currency
        );
        $targetWalletTransaction = new UserWalletTransaction();
        $targetWalletTransaction->document_id = $document->id;
        $targetWalletTransaction->user_wallet_id = $targetWallet->id;
        $targetWalletTransaction->amount = $targetAmount;

        $targetWalletTransaction->save();
    }

    public function backward(Document $document)
    {
        foreach ($document->transactions as $transaction) {
            $transaction->delete();
        }

        $document->setAsCanceled();
        $document->save();
    }

    private function validateWallet($targetWallet)
    {
        $errors = [];
        if (null === $targetWallet) {
            $errors['target_wallet_id'] = ['Target wallet not found'];
        }
        if (!empty($errors)) {
            throw new UserWalletNotFoundException($errors);
        }
    }

    private function getSourceCurrency(AddFundsDto $dto)
    {
        $currency = Currency::findOne($dto->getCurrencyId());
        if (null === $currency) {
            throw new CurrencyNotFoundException(
                ['currencyId' => [
                    'Currency not found',
                ]]
            );
        }

        return $currency;
    }

    protected function isSupportedDto($dto): bool
    {
        return $dto instanceof AddFundsDto;
    }
}