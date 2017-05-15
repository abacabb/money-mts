<?php

namespace app\services\business\dto;

/**
 * DTO для огранияения выборки из коллекций
 *
 * Class LimitDto
 * @package app\services\business\dto
 */
class LimitDto extends BaseDto
{
    const MAX_LIMIT = 100;

    public $limit;

    public $offset;

    public function rules()
    {
        return [
            [['limit', 'offset'], 'safe'],
            [['limit'], 'integer', 'min' => 1, 'max' => self::MAX_LIMIT],
            [['offset'], 'integer', 'min' => 0],
            // default values
            [['limit'], 'default', 'value' => self::MAX_LIMIT],
            [['offset'], 'default', 'value' => 0],
        ];
    }

    /**
     * @return mixed
     */
    public function getLimit()
    {
        return $this->limit;
    }

    /**
     * @return mixed
     */
    public function getOffset()
    {
        return $this->offset;
    }
}