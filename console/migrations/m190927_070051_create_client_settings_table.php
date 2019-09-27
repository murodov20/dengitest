<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%client_settings}}`.
 */
class m190927_070051_create_client_settings_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%client_settings}}', [
            'key' => $this->string(50),
            'value' => $this->text(),
        ]);

        $this->addPrimaryKey('client_settings-key-pk', '{{%client_settings}}', 'key');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropPrimaryKey('client_settings', '{{%client_settings}}');
        $this->dropTable('{{%client_settings}}');
    }
}
