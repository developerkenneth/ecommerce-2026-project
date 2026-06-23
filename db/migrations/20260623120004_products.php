<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class Products extends AbstractMigration
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

        // create table
        $table = $this->table("products");
        $table->addColumn("name", "text", ['limit' => 1000])
            ->addColumn('uuid', 'uuid')
            ->addColumn("price", "decimal", ['limit' => 11, 'precision' => 2])
            ->addColumn("status", "enum", ['values' => ['draft', 'published']])
            ->addColumn('featured', 'boolean')
            ->addColumn('description', 'text', ['limit' => 2500])
            ->addColumn("tags", "json")
            ->addColumn("brand", "string", ['limit' => 255])
            ->addColumn('user_id', 'integer', ['limit' => 11])
            ->addTimestamps()->create();
    }
}
