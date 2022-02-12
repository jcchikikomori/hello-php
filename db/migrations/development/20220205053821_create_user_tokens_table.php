<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateUserTokensTable extends AbstractMigration
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
        $this->table('access_tokens', ['id' => false, 'primary_key' => ['id']])
            ->addColumn('id', 'integer', ['null' => false, 'identity' => 'enable'])
            ->addColumn('selector', 'string', ['null' => false, 'limit' => 255])
            ->addColumn('hashed_validator', 'string', ['null' => false, 'limit' => 255])
            ->addColumn('user_id', 'integer', ['null' => true, 'limit' => 10])
            ->addColumn('expiry', 'timestamp', ['null' => false])
            ->addForeignKey('user_id', 'users', ['user_id'], ['delete'=> 'RESTRICT', 'update'=> 'NO_ACTION'])
            ->create();
    }
}
