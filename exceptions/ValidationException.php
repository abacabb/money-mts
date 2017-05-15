<?php

namespace app\exceptions;

/**
 * Class ValidationException
 * @package app\exceptions
 */
class ValidationException extends PublicException
{
    public function __construct(array $errors, $message = 'Validation failed', $code = 422, \Throwable $previous = null)
    {
        parent::__construct($errors, $message, $code, $previous);
    }
}