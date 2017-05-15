<?php
declare(strict_types=1);

namespace app\models\document\operations;


use app\models\document\Document;
use app\models\document\DocumentOperationInterface;
use app\models\UserWallet;
use app\models\UserWalletTransaction;
use app\services\business\CurrencyService;
use app\services\business\dto\TransferDto;
use app\services\business\exceptions\InsufficientFundsOnWalletException;
use app\services\business\exceptions\UserWalletNotFoundException;
use app\services\business\WalletService;

/**
 * Перевод с кошелька на кошелек
 *
 * Class TransferWalletToWallet
 * @package app\models\document\operations
 */
class TransferWalletToWallet extends AbstractDTOedDocumentOperation implements DocumentOperationInterface
{
    private $walletService;

    private $currencyService;

    public function __construct(
        WalletService $walletService,
        CurrencyService $currencyService
    ) {
        $this->walletService = $walletService;
        $this->currencyService = $currencyService;
    }

    public function forward(Document $document)
    {
        $this->validateDocument($document);

        /** @var TransferDto $dto */
        $dto = $this->getDto();
        $sourceWallet = UserWallet::findOne($dto->getSourceWalletId());
        $targetWallet = UserWallet::findOne($dto->getTargetWalletId());
        $this->validateWallets($sourceWallet, $targetWallet);
        $this->validateAmount($dto->getAmount(), $sourceWallet);

        $sourceWalletTransaction = new UserWalletTransaction();
        $sourceWalletTransaction->document_id = $document->id;
        $sourceWalletTransaction->user_wallet_id = $sourceWallet->id;
        $sourceWalletTransaction->amount = (-1) * $dto->getAmount();

        $targetAmount = $this->currencyService->exchange(
            $dto->getAmount(),
            $sourceWallet->systemWallet->currency,
            $targetWallet->systemWallet->currency
        );
        $targetWalletTransaction = new UserWalletTransaction();
        $targetWalletTransaction->document_id = $document->id;
        $targetWalletTransaction->user_wallet_id = $targetWallet->id;
        $targetWalletTransaction->amount = $targetAmount;

        $sourceWalletTransaction->save();
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

    private function validateWallets($sourceWallet, $targetWallet)
    {
        $errors = [];
        if (null === $sourceWallet) {
            $errors['source_wallet_id'] = ['Source wallet not found'];
        }
        if (null === $targetWallet) {
            $errors['target_wallet_id'] = ['Target wallet not found'];
        }
        if (!empty($errors)) {
            throw new UserWalletNotFoundException($errors);
        }
    }

    private function validateAmount(float $amount, UserWallet $sourceWallet)
    {
        if ($amount > $this->walletService->balance($sourceWallet)) {
            throw new InsufficientFundsOnWalletException([
                'amount' => ['Insufficient funds on source wallet'], // at
            ]);
        }
    }

    protected function isSupportedDto($dto): bool
    {
        return $dto instanceof TransferDto;
    }
}