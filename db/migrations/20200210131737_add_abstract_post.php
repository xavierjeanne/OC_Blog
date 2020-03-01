<?php

use Phinx\Migration\AbstractMigration;

class AddAbstractPost extends AbstractMigration
{

    public function change()
    {
        $this->table('posts')
            ->addColumn('abstract', 'string', ['limit' => 250])
            ->save();
    }
}
