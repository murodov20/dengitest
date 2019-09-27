<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%api_user_wallets}}`.
 */
class m190927_055110_create_api_user_wallets_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%api_user_wallets}}', [
            'id' => $this->primaryKey(),
            'api_user_id' => $this->integer()->notNull(),
            'user_id' => $this->integer()->notNull(),
            'sum' => $this->double(),
        ]);

        $this->createIndex(
            'idx-api_user_wallets-user_id-api_user_id',
            '{{%api_user_wallets}}',
            ['user_id', 'api_user_id'],
            true
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropIndex('idx-api_user_wallets-user_id-api_user_id', '{{%api_user_wallets}}');
        $this->dropTable('{{%api_user_wallets}}');
    }
}
