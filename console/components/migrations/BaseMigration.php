<?php

namespace console\components\migrations;

class BaseMigration extends \yii\db\Migration
{
	/**
	 * @return bool
	 */
	public function isMySql()
	{
		return $this->db->driverName === 'mysql';
	}

	/**
	 * @return bool
	 */
	public function isPgSql()
	{
		return $this->db->driverName === 'pgsql';
	}

	/**
	 * @return bool
	 */
	public function isJsonSupported()
	{
		return $this->isPgSql();
	}

	/**
	 * @return null|string
	 */
	public function tableOptions()
	{
		$tableOptions = null;

		if ($this->isMySql()) {
			// http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
			$tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
		}

		return $tableOptions;
	}
}
