<?php
use Migrations\AbstractMigration;

class CreateUsers extends AbstractMigration
{
    public function change(): void
    {
        $this->table('users', ['collation' => 'utf8_general_ci'])
            ->addColumn('email', 'string', [
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('pass', 'string', [
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('name', 'string', [
                'limit' => 255,
                'null' => false,
            ])->addColumn('created', 'datetime', [
                'null' => false,
            ])->addColumn('modified', 'datetime', [
                'null' => false,
            ])->addColumn('deleted', 'datetime', [
                'null' => true,
                'default' => null
            ])
            ->addPrimaryKey('id')
            ->addIndex(['email'], [
                'unique' => true,
                'name' => 'email'
            ])
            ->create()
        ;
    }
}
