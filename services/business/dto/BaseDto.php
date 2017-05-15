<?php

namespace app\services\business\dto;


use app\exceptions\PublicException;
use yii\base\Model;

/**
 * Базовая DTO которая умеет загружать данные из "массива" и валидировать
 * Получилось не совсем DTO
 *
 * Class BaseDto
 * @package app\services\business\dto
 */
class BaseDto extends Model
{

    /**
     * Метод загружает данные и если они не валидны - выбрасывает исключение
     *
     * @param array $values
     * @throws PublicException
     */
    public function mustLoad(array $values)
    {
        $this->load($values, '');

        if (!$this->validate()) {
            throw new PublicException($this->getErrors());
        }
    }
}