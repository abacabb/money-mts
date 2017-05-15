<?php

namespace app\models\document;


use app\models\UserWalletTransaction;
use yii\db\ActiveRecord;

/**
 * Докемент представляет собой некоторый тип операции.
 * В зависимости от типа документа и контекста, выполняет различные бизнес действия.
 * Может порождать документы-потомки.
 *
 * Class Document
 * @package app\models
 *
 * @property $id;
 * @property $parent_document_id документ потомок
 * @property $status статус документа
 * @property $operation_type тип документа
 * @property $created_at дата создания
 * @property $completed_at дата выполнения
 * @property $canceled_at дата отката
 *
 * @property UserWalletTransaction[] $transactions;
 */
class Document extends ActiveRecord
{
    const STATUS_CREATED = 'created';
    const STATUS_COMPLETED = 'completed';
    const STATUS_CANCELED = 'canceled';

    /**
     * Контекстная операция исполнения документа, может также порождать документы потомки
     * Является основной рабочей сущностью
     *
     * @var DocumentOperationInterface
     */
    private $operation;

    /**
     * Получить список транзакий по данному документу
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTransactions()
    {
        return $this->hasMany(UserWalletTransaction::class, ['document_id' => 'id']);
    }

    /**
     * Выполнить документ, т.е. совершить список атомарных операций, как описано выше
     */
    public function forward()
    {
        $this->getOperation()->forward($this);
    }

    /**
     * Откатить документ
     */
    public function backward()
    {
        $this->getOperation()->backward($this);
    }

    /**
     * @return DocumentOperationInterface
     */
    public function getOperation(): DocumentOperationInterface
    {
        return $this->operation;
    }

    /**
     * @param DocumentOperationInterface $operation
     */
    public function setOperation(DocumentOperationInterface $operation)
    {
        $this->operation = $operation;
        // конечно это не очень правильно, т.к. затрудняет рефакторинг. Но...
        $this->operation_type = get_class($operation);
    }

    public function setAsCreated()
    {
        $this->status = static::STATUS_CREATED;
        $this->created_at = date('Y-m-d H:i:s');
    }

    public function setAsCompleted()
    {
        $this->status = static::STATUS_COMPLETED;
        $this->completed_at = date('Y-m-d H:i:s');
    }

    public function setAsCanceled()
    {
        $this->status = static::STATUS_CANCELED;
        $this->canceled_at = date('Y-m-d H:i:s');
    }

    public static function create()
    {
        $document = new static();
        $document->setAsCreated();

        return $document;
    }

    /**
     * Документ выполнен?
     * @return bool
     */
    public function isCompleted()
    {
        return $this->status === self::STATUS_COMPLETED;
    }
}
