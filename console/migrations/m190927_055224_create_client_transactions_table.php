<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%client_transactions}}`.
 */
class m190927_055224_create_client_transactions_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%client_transactions}}', [
            'id' => $this->bigPrimaryKey(),
            'order_number' => $this->integer()->notNull(),
            'sum' => $this->double()->notNull(),
            'commission' => $this->double()->notNull(),
            'created_at' => $this->integer()->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%client_transactions}}');
    }
}
