<?php

use yii\db\Migration;

/**
 * Handles the creation of table `user_wallet`.
 */
class m170514_100935_create_user_wallet_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('user_wallet', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'wallet_id' => $this->integer()->notNull(),
        ]);

        $this->addForeignKey(
            'fk-user_wallet-user_id',
            'user_wallet',
            'user_id',
            'user',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-user_wallet-wallet_id',
            'user_wallet',
            'wallet_id',
            'system_wallet',
            'id',
            'CASCADE'
        );
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('user_wallet');
    }
}
