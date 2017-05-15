<?php

use yii\db\Migration;

/**
 * Handles the creation of table `user`.
 */
class m170513_065753_create_user_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('user', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('user');
    }
}
