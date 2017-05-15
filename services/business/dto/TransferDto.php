<?php

namespace app\services\business\dto;

/**
 * DTO для перевода со счета на счет
 *
 * Class TransferDto
 * @package app\services\business\dto
 */
class TransferDto extends BaseDto
{
    /**
     * Кошелек назначения
     *
     * @var integer
     */
    protected $targetWalletId;

    /**
     * Кошелек списания
     *
     * @var integer
     */
    protected $sourceWalletId;

    /**
     * Сумма списания/пополнения
     *
     * @var float
     */
    protected $amount;

    public function rules()
    {
        return [
            [['targetWalletId', 'sourceWalletId', 'amount'], 'safe'],
            [['targetWalletId', 'sourceWalletId', 'amount'], 'required'],
            [['targetWalletId', 'sourceWalletId'], 'integer'],
            [['targetWalletId'], 'compare', 'compareAttribute' => 'sourceWalletId', 'operator' => '!=='],
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
     * @return int
     */
    public function getSourceWalletId(): int
    {
        return $this->sourceWalletId;
    }

    /**
     * @return float
     */
    public function getAmount(): float
    {
        return $this->amount;
    }
}