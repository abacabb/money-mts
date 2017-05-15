<?php

namespace app\models\document;

/**
 * Операция исполняяющая документ
 *
 * Interface DocumentOperationInterface
 * @package app\models\document
 */
interface DocumentOperationInterface
{
    public function forward(Document $document);

    public function backward(Document $document);
}