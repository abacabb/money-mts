<?php

use yii\db\Migration;

/**
 * Handles the creation of table `document`.
 */
class m170514_101121_create_document_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('document', [
            'id' => $this->primaryKey(),
            'parent_document_id' => $this->integer(),
            'status' => $this->string()->notNull(),
            'operation_type' => $this->string()->notNull(),
            'created_at' => $this->dateTime()->defaultExpression('NOW()'),
            'completed_at' => $this->dateTime(),
            'canceled_at' => $this->dateTime(),
        ]);

        $this->addForeignKey(
            'fk-document-parent_document_id',
            'document',
            'parent_document_id',
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
        $this->dropTable('document');
    }
}
