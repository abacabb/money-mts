<?php

namespace app\services\business\exceptions;


use app\exceptions\ValidationException;

/**
 * Недостаточно средст на кошельке
 *
 * Class InsufficientFundsOnWalletException
 * @package app\services\business\exceptions
 */
class InsufficientFundsOnWalletException extends ValidationException
{

}