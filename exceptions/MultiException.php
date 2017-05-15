<?php

namespace app\exceptions;

/**
 * Исключение может содержать список ошибок
 *
 * Class MultiException
 * @package app\exceptions
 */
class MultiException extends \Exception
{
    private $errors = [];

    public function __construct(array $errors, $message = '', $code = 0, \Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
        $this->errors = $errors;
    }

    public function getErrors()
    {
        return $this->errors;
    }
}
