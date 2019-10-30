<?php

use yii\db\Migration;

/**
 * Class m191008_144027_robotsDisallowRecords
 */
class m191008_144027_robotsDisallowRecords extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $options = ($this->db->getDriverName() === 'mysql') ? 'ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci' : null;

        $this->createTable('{{%robots_disallow_record}}', [
            'id' => $this->primaryKey(),
            'modelClass' => $this->string(64)->notNull(),
            'recordId' => $this->integer()->notNull(),
            'createdAt' => $this->dateTime()->null()->defaultValue(null),
            'updatedAt' => $this->dateTime()->null()->defaultValue(null),
        ], $options);

        $this->createIndex('idx-unique', '{{%robots_disallow_record}}', ['modelClass', 'recordId'], true);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%robots_disallow_record}}');
    }
}
