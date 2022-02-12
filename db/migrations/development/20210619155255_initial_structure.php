<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class InitialStructure extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * https://book.cakephp.org/phinx/0/en/migrations.html#the-change-method
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function change(): void
    {
        $this->table('reset_codes', [
            'id' => false, 'primary_key' => ['id'],
        ])
        ->addColumn('id', 'integer', [
            'null' => false,
            'limit' => '10',
            'identity' => 'enable',
        ])
        ->addColumn('code', 'string', [
            'null' => false,
            'limit' => 30,
            'after' => 'id',
        ])
        ->addColumn('email', 'string', [
            'null' => false,
            'limit' => 64,
            'after' => 'code',
        ])
        ->addColumn('created', 'timestamp', [
            'null' => false,
            'after' => 'email',
        ])
        ->addIndex(['code'], [
            'name' => 'code',
            'unique' => true,
        ])
        ->addIndex(['code'], [
            'name' => 'random_code',
            'unique' => false,
        ])
        ->addIndex(['email'], [
            'name' => 'reset_email',
            'unique' => false,
        ])
        ->create();
        $this->table('users', [
            'id' => false,
            'primary_key' => ['user_id'],
            'comment' => 'user data',
        ])
        ->addColumn('user_id', 'integer', [
            'null' => false,
            'limit' => '10',
            'identity' => 'enable',
            'comment' => 'auto incrementing user_id of each user, unique index',
        ])
        ->addColumn('user_name', 'string', [
            'null' => false,
            'limit' => 64,
            'comment' => 'user\'s name, unique',
            'after' => 'user_id',
        ])
        ->addColumn('user_password', 'string', [
            'null' => true,
            'default' => null,
            'limit' => 255,
            'comment' => 'user\'s password in salted and hashed format',
            'after' => 'user_name',
        ])
        ->addColumn('user_email', 'string', [
            'null' => false,
            'limit' => 64,
            'comment' => 'user\'s email, unique',
            'after' => 'user_password',
        ])
        ->addColumn('first_name', 'string', [
            'null' => false,
            'limit' => 160,
            'after' => 'user_email',
        ])
        ->addColumn('middle_name', 'string', [
            'null' => false,
            'limit' => 160,
            'after' => 'first_name',
        ])
        ->addColumn('last_name', 'string', [
            'null' => false,
            'limit' => 160,
            'after' => 'middle_name',
        ])
        ->addColumn('user_account_type', 'text', [
            'null' => false,
            'limit' => 65535,
            'after' => 'last_name',
        ])
        ->addColumn('created', 'timestamp', [
            'null' => false,
            'after' => 'user_account_type',
        ])
        ->addColumn('modified', 'timestamp', [
            'null' => false,
            'after' => 'created',
        ])
        ->create();
        $this->table('user_types', [
            'id' => false,
            'primary_key' => ['id'],
        ])
        ->addColumn('id', 'integer', [
            'null' => false
        ])
        ->addColumn('user_type', 'string', [
            'null' => false,
            'limit' => 20,
            'after' => 'id',
        ])
        ->addColumn('type_desc', 'string', [
            'null' => false,
            'limit' => 300,
            'comment' => 'Full information about this user type',
            'after' => 'user_type',
        ])
        ->create();
    }
}
