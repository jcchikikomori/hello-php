<?php

use Phinx\Seed\AbstractSeed;

class UserTypes extends AbstractSeed
{
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeders is available here:
     * https://book.cakephp.org/phinx/0/en/seeding.html
     */
    public function run()
    {
        $data = [
            [
                'id'        => 0,
                'user_type' => 'admin',
                'type_desc' => 'Administrators',
            ],
            [
                'id'        => 1,
                'user_type' => 'user',
                'type_desc' => 'Users',
            ]
        ];
        $posts = $this->table('user_types');
        $posts->insert($data)
              ->saveData();
    }
}
