<?php

namespace app\services\business\dto;

/**
 * Class HistoryDto
 * @package app\services\business\dto
 */
class HistoryDto extends LimitDto
{
    protected $walletId;

    public function rules()
    {
        return array_merge([
            ['walletId', 'safe'],
            ['walletId', 'integer'],
        ], parent::rules());
    }

    /**
     * @return mixed
     */
    public function getWalletId()
    {
        return $this->walletId;
    }
}