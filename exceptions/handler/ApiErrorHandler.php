<?php

namespace app\exceptions\handler;

use app\exceptions\PublicException;
use yii\web\ErrorHandler;
use yii\web\Response;

/**
 * Кастомный обработчик исключений
 * Что бы для пользователя не выводились системный ошибки, нужно YII_DEBUG поставить в true
 * web/index.php:4
 *
 * Class ApiErrorHandler
 * @package app\exceptions\handler
 */
class ApiErrorHandler extends ErrorHandler
{
    protected function renderException($exception)
    {
        if (YII_DEBUG) {
            parent::renderException($exception);

            return;
        }
        if (\Yii::$app->has('response')) {
            $response = \Yii::$app->getResponse();
        } else {
            $response = new Response();
        }

        $response->data = $this->convertExceptionToArray($exception);
        $statusCode = $exception->getCode() ?: 500;
        $response->setStatusCode($statusCode);

        $response->send();
    }

    protected function convertExceptionToArray($exception)
    {
        if (YII_DEBUG) {
            return parent::convertExceptionToArray($exception);
        }
        if ($exception instanceof PublicException) {
            return $this->convertPublicException($exception);
        }

        return $this->convertOtherException();
    }

    protected function convertPublicException(PublicException $exception)
    {
        return [
            'message' => $exception->getMessage(),
            'errors' => $exception->getErrors(),
        ];
    }

    protected function convertOtherException()
    {
        return [
            'message' => 'Something went wrong',
            'errors' => []
        ];
    }
}