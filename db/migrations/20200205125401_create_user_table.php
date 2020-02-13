<?php

use Phinx\Migration\AbstractMigration;

class CreateUserTable extends AbstractMigration
{

    public function change()
    {
        $this->table('users')
            ->addColumn('name', 'string', ['limit' => 30])
            ->addColumn('first_name', 'string', ['limit' => 30])
            ->addColumn('login', 'string', ['limit' => 30])
            ->addColumn('password', 'string', ['limit' => 40])
            ->addColumn('email', 'string', ['limit' => 250])
            ->addColumn('avatar', 'string', ['limit' => 250, 'null' => true])
            ->addColumn('status', 'enum', ['values' => ['visitor', 'admin'], 'default' => 'visitor'])
            ->addIndex(['login', 'email'], ['unique' => true])
            ->create();
    }
}
