<?php
namespace App\Model\Table;

use Cake\ORM\Table;

class AccountsTable extends Table
{
	public function initialize(array $config)
	{
		$this->table('accounts');
		$this->primaryKey(['id']);
	}

	public static function defaultConnectionName()
	{
		return 'lookup';
	}
}