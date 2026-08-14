<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateCartItems extends AbstractMigration
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
        $table = $this->table('cart_items');

        $table
            ->addColumn('user_id', 'integer',['limit'=>11])
            ->addColumn('product_uuid', 'uuid')
            ->addColumn('quantity', 'integer', [
                'default' => 1,
                'signed' => false
            ])
            ->addTimestamps()
            ->addIndex(
                ['user_id', 'product_uuid'],
                [
                    'unique' => true
                ]
            )
            ->create();
    }
    }

