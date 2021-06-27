<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%points}}`.
 */
class m210627_174527_create_points_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%points}}', [
            'id' => $this->primaryKey(),
            'point' => $this->string(11)->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%points}}');
    }
}
