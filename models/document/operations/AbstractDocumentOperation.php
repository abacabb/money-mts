<?php

namespace app\models\document\operations;


use app\models\document\Document;

abstract class AbstractDocumentOperation
{
    public function validateDocument(Document $document)
    {
        if ($document->operation_type !== static::class) {
            throw new \Exception();
        }
    }
}