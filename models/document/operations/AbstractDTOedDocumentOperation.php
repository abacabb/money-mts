<?php

namespace app\models\document\operations;

/**
 * Операции, который зависят от контекста исполнения
 *
 * Class AbstractDTOedDocumentOperation
 * @package app\models\document\operations
 */
abstract class AbstractDTOedDocumentOperation extends AbstractDocumentOperation
{
    private $dto;

    abstract protected function isSupportedDto($dto): bool;

    public function setDto($dto)
    {
        if (!$this->isSupportedDto($dto)) {
            throw new \InvalidArgumentException();
        }
        $this->dto = $dto;
    }

    public function getDto()
    {
        if (!$this->isSupportedDto($this->dto)) {
            throw new \UnexpectedValueException();
        }

        return $this->dto;
    }
}