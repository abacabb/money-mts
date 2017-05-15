<?php

use yii\db\Migration;

/**
 * Handles the creation of table `currency`.
 */
class m170513_070305_create_currency_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('currency', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'ratio' => $this->float()->notNull(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('currency');
    }
}
