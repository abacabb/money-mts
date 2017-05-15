<?php

use yii\db\Migration;

/**
 * Handles the creation of table `user_wallet_transaction`.
 */
class m170514_101242_create_user_wallet_transaction_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('user_wallet_transaction', [
            'id' => $this->primaryKey(),
            'user_wallet_id' => $this->integer()->notNull(),
            'document_id' => $this->integer()->notNull(),
            'amount' => $this->float()->notNull(),
            'created_at' => $this->dateTime()->defaultExpression('NOW()'),
        ]);

        $this->addForeignKey(
            'fk-user_wallet_transaction-user_wallet_id',
            'user_wallet_transaction',
            'user_wallet_id',
            'user_wallet',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-user_wallet_transaction-document_id',
            'user_wallet_transaction',
            'document_id',
            'document',
            'id',
            'CASCADE'
        );
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('user_wallet_transaction');
    }
}
