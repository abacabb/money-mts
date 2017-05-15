<?php

namespace app\services\business\dto;

/**
 * DTO для пополнения кошелька
 *
 * Class AddFundsDto
 * @package app\services\business\dto
 */
class AddFundsDto extends BaseDto
{
    /**
     * Кошелек для пополнения
     *
     * @var integer
     */
    protected $targetWalletId;

    /**
     * Валюта пополнения
     *
     * @var float
     */
    protected $currencyId;

    /**
     * Сумма пополнения
     *
     * @var float
     */
    protected $amount;

    public function rules()
    {
        return [
            [['targetWalletId', 'currencyId', 'amount'], 'safe'],
            [['targetWalletId', 'currencyId', 'amount'], 'required'],
            [['targetWalletId', 'currencyId'], 'integer'],
            [['amount'], 'number', 'min' => 0.01],
        ];
    }

    /**
     * @return int
     */
    public function getTargetWalletId(): int
    {
        return $this->targetWalletId;
    }

    /**
     * @return float
     */
    public function getAmount(): float
    {
        return $this->amount;
    }

    /**
     * @return mixed
     */
    public function getCurrencyId()
    {
        return $this->currencyId;
    }
}