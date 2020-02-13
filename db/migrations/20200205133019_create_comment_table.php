<?php

use Phinx\Migration\AbstractMigration;

class CreateCommentTable extends AbstractMigration
{

    public function change()
    {
        $this->table('comments')
            ->addColumn('comment', 'text', ['limit' => \Phinx\Db\Adapter\MysqlAdapter::TEXT_LONG])
            ->addColumn('created_at', 'datetime')
            ->addColumn('updated_at', 'datetime')
            ->addColumn('user_id', 'integer')
            ->addColumn('post_id', 'integer')
            ->addColumn('status', 'enum', ['values' => ['draft', 'published'], 'default' => 'draft'])
            ->addForeignKey('user_id', 'users', 'id', ['delete' => 'NO_ACTION', 'update' => 'NO_ACTION'])
            ->addForeignKey('post_id', 'posts', 'id', ['delete' => 'NO_ACTION', 'update' => 'NO_ACTION'])
            ->create();
    }
}
