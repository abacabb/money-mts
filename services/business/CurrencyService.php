<?php

namespace app\services\business;


use app\models\Currency;

/**
 * Сервис для работы с валютой
 *
 * Class CurrencyService
 * @package app\services\business
 */
class CurrencyService
{

    /**
     * Перевод из одной валюты в другую
     *
     * @param float $amount сумма пересчета
     * @param Currency $sourceCurrency исходная валюта
     * @param Currency $targetCurrency валюта назначения
     * @return float
     */
    public function exchange(float $amount, Currency $sourceCurrency, Currency $targetCurrency): float
    {
        if ($sourceCurrency->id === $targetCurrency->id) {
            return $amount;
        }

        // USD = 1.2
        // RUB = 0.1
        // 100 = 100
        // 100 * 1.2 = 120
        // 120 / 0.1 = 1200
        $amount = $amount * $sourceCurrency->ratio;
        $amount = $amount / $targetCurrency->ratio;

        return $amount;
    }
}