<?php

use yii\db\Migration;

/**
 * Handles the creation of table `wallet`.
 */
class m170513_070311_create_wallet_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('system_wallet', [
            'id' => $this->primaryKey(),
            'currency_id' => $this->integer()->notNull(),
            'name' => $this->string()->notNull(),
        ]);

        $this->addForeignKey(
            'fk-system_wallet-currency_id',
            'system_wallet',
            'currency_id',
            'currency',
            'id',
            'CASCADE'
        );
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('system_wallet');
    }
}
