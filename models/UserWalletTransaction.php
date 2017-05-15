<?php

namespace app\models;


use app\models\document\Document;
use yii\db\ActiveRecord;

/**
 * Транзакции совершаемые с кошельком пользователя
 *
 * Class WalletOperation
 * @package app\models
 *
 * @property $id;
 * @property $user_wallet_id;
 * @property $document_id;
 * @property $amount;
 * @property $created_at;
 *
 * @property Document $document;
 */
class UserWalletTransaction extends ActiveRecord
{
    public function getDocument()
    {
        return $this->hasOne(Document::class, ['id' => 'document_id']);
    }
}