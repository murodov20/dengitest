<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%api_transactions}}`.
 */
class m190927_055100_create_api_transactions_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%api_transactions}}', [
            'id' => $this->bigPrimaryKey(),
            'external_id' => $this->bigInteger()->notNull(),
            'api_user_id' => $this->integer()->notNull(),
            'user_id' => $this->integer()->notNull(),
            'sum' => $this->double()->notNull(),
            'created_at' => $this->integer()->notNull(),
        ]);

        $this->createIndex(
            'idx-api_transactions-external_id-api_user_id',
            '{{%api_transactions}}',
            ['external_id', 'api_user_id'],
            true
            );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropIndex('idx-api_transactions-external_id-api_user_id', '{{%api_transactions}}');
        $this->dropTable('{{%api_transactions}}');
    }
}
