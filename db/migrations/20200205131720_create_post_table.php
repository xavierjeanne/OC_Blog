<?php

use Phinx\Migration\AbstractMigration;

class CreatePostTable extends AbstractMigration
{

    public function change()
    {
        $this->table('posts')
            ->addColumn('title', 'string', ['limit' => 255])
            ->addColumn('content', 'text', ['limit' => \Phinx\Db\Adapter\MysqlAdapter::TEXT_LONG])
            ->addColumn('picture', 'string', ['limit' => 250, 'null' => true])
            ->addColumn('created_at', 'datetime')
            ->addColumn('updated_at', 'datetime')
            ->addColumn('user_id', 'integer')
            ->addColumn('status', 'enum', ['values' => ['draft', 'published'], 'default' => 'draft'])
            ->addForeignKey('user_id', 'users', 'id', ['delete' => 'NO_ACTION', 'update' => 'NO_ACTION'])
            ->create();
    }
}
