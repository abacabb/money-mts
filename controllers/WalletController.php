<?php

namespace app\controllers;


use app\exceptions\PublicException;
use app\models\db\Limiter;
use app\models\UserWallet;
use app\models\UserWalletTransaction;
use app\services\business\DocumentService;
use app\services\business\dto\AddFundsDto;
use app\services\business\dto\LimitDto;
use app\services\business\dto\TransferDto;
use app\services\business\WalletService;
use yii\data\ArrayDataProvider;

class WalletController extends ApiController
{
    private $walletService;

    public function verbs()
    {
        return [
            'view' => ['GET', 'HEAD'],
            'transfer' => ['POST'],
            'add-funds' => ['POST'],
            'history' => ['GET', 'HEAD'],
        ];
    }

    public function __construct($id, $module, WalletService $walletService, array $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->walletService = $walletService;
    }

    /**
     * GET http://domain/api/v1/wallets/1
     *
     * Получить инфу по кошельку пользователя с ид = 1
     *
     * @param $id
     * @return array
     */
    public function actionView($id)
    {
        $wallet = $this->findWallet($id);
        $result = $wallet->toArray();
        $result['balance'] = $this->walletService->balance($wallet);

        return $result;
    }

    /**
     * POST http://domain/api/v1/wallets/transfer
     * {
     *   "sourceWalletId": 1,
     *   "targetWalletId": 2,
     *   "amount": 30
     * }
     *
     * Перевести средства с одного кошелька на другой
     * @return UserWalletTransaction[]
     */
    public function actionTransfer()
    {
        $dto = new TransferDto();
        $dto->mustLoad($this->getRequest()->post());
        /** @var DocumentService $service */
        $service = \Yii::$container->get('document_service');
        $result = $service->transfer($dto);

        return $result->transactions;
    }

    /**
     * POST http://domain/api/v1/wallets/add-funds
     * {
     *   "targetWalletId": 1,
     *   "currencyId": 1,
     *   "amount": 100
     * }
     *
     * Пополнить кошелек
     * @return UserWalletTransaction[]
     */
    public function actionAddFunds()
    {
        $dto = new AddFundsDto();
        $dto->mustLoad($this->getRequest()->post());
        /** @var DocumentService $service */
        $service = \Yii::$container->get('document_service');
        $document = $service->addFunds($dto);

        return $document->transactions[0];
    }

    /**
     * GET http://domain/api/v1/wallets/1/history
     *
     * Показать историю транзакций для кошелька с ид = 1
     * @param $id
     * @return ArrayDataProvider
     */
    public function actionHistory($id)
    {
        $wallet = $this->findWallet($id);
        $limitDto = new LimitDto();
        $limitDto->mustLoad($this->getRequest()->get());
        $limiter = new Limiter($limitDto->getLimit(), $limitDto->getOffset());

        $transactions = $this->walletService->transactionsHistory($wallet, $limiter);

        $result = [];
        /** @var UserWalletTransaction $transaction */
        foreach ($transactions as $transaction) {
            $item = $transaction->toArray();
            $item['status'] = $transaction->document->status;
            $result[] = $item;
        }

        return new ArrayDataProvider([
            'allModels' => $result,
            'pagination' => false,
        ]);
    }

    private function findWallet($id)
    {
        $wallet = UserWallet::findOne($id);
        if (null === $wallet) {
            throw new PublicException([], 'Wallet not found');
        }

        return $wallet;
    }
}