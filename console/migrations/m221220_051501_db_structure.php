<?php

use yii\db\Migration;

final class m221220_051501_db_structure extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;

        $isMySql = $this->db->driverName === 'mysql';
        $isPgSql = $this->db->driverName === 'pgsql';

        if ($isMySql) {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $isJsonSupported = $isPgSql;

        $this->createTable('{{%settings}}', [
            'id' => $this->primaryKey(),
            'key' => $this->string()->notNull()->unique(),
            'value' => $this->text(),
            'description' => $this->text(),
        ], $tableOptions);
    }

    public function safeDown()
    {
        $this->dropTable('{{%settings}}');
    }
}
