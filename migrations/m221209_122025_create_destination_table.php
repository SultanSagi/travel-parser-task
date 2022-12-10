<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%destination}}`.
 */
class m221209_122025_create_destination_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%destination}}', [
            'country_id' => $this->integer()->notNull(),
            'city_id' => $this->integer()->notNull(),
            'price' => $this->integer()->notNull(),
            'cur' => $this->string(),
            'days' => $this->string(300),
            'defautDate' => $this->string(300),
        ]);

        $this->addPrimaryKey('{{%pk-destination}}', '{{%destination}}', ['country_id', 'city_id']);

        $this->addForeignKey('{{%fk-destination-country_id}}', '{{%destination}}', 'country_id', '{{%country}}', 'id', 'CASCADE', 'RESTRICT');
        $this->addForeignKey('{{%fk-destination-city_id}}', '{{%destination}}', 'city_id', '{{%city}}', 'id', 'CASCADE', 'RESTRICT');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%destination}}');
    }
}
