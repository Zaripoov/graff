<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%libra}}`.
 */
class m210627_175055_create_libra_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%libra}}', [
            'id' => $this->primaryKey(),
            'start_point' => $this->integer(11)->notNull(),
            'end_point' => $this->integer(11)->notNull(),
            'libra' => $this->integer(11)->notNull(),
        ]);
        
        // Добавляем foreign key
        $this->addForeignKey(
            'start_point_point', // это "условное имя" ключа
            'libra', // это название текущей таблицы
            'start_point', // это имя поля в текущей таблице, которое будет ключом
            'points', // это имя таблицы, с которой хотим связаться
            'id', // это поле таблицы, с которым хотим связаться
            'CASCADE'

        );

        // Добавляем foreign key
        $this->addForeignKey(
            'end_point_point', // это "условное имя" ключа
            'libra', // это название текущей таблицы
            'end_point', // это имя поля в текущей таблице, которое будет ключом
            'points', // это имя таблицы, с которой хотим связаться
            'id', // это поле таблицы, с которым хотим связаться
            'CASCADE'

        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%libra}}');
    }
}
