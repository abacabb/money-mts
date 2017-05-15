<?php

namespace app\models\db;


use yii\db\ActiveQuery;

/**
 * Вспомогательный класс, для задания offset и limit для ActiveQuery
 *
 * Class Limiter
 * @package app\models\db
 */
class Limiter
{
    private $limit;

    private $offset;

    public function __construct(int $limit = 0, int $offset = 0)
    {
        $this->limit = $limit;
        $this->offset = $offset;
    }

    /**
     * @return int
     */
    public function getLimit(): int
    {
        return $this->limit;
    }

    /**
     * @return int
     */
    public function getOffset(): int
    {
        return $this->offset;
    }

    public function bindQuery(ActiveQuery $query)
    {
        if ($this->getLimit()) {
            $query->limit($this->getLimit());
        }

        if ($this->getOffset()) {
            $query->offset($this->getOffset());
        }

        return $query;
    }
}