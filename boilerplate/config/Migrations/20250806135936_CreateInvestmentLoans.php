<?php
use Migrations\AbstractMigration;

class CreateInvestmentLoans extends AbstractMigration
{
    /**
     * Change Method.
     *
     * More information on this method is available here:
     * https://book.cakephp.org/phinx/0/en/migrations.html#the-change-method
     * @return void
     */
    public function change()
    {
        $table = $this->table('investment_loans');
        $table->addColumn('title', 'string', [
            'default' => null,
            'limit' => 255,
            'null' => false,
        ]);
        $table->addColumn('max_amount', 'float', [
            'null' => false
        ]);
        $table->addColumn('max_interest', 'float', [
            'null' => false
        ]);
        $table->addColumn('min_interest', 'float', [
            'null' => false
        ]);
        $table->addColumn('max_duration_months', 'integer', [
            'null' => false,
        ]);
        $table->addColumn('min_duration_months', 'integer', [
            'null' => false,
        ]);
        $table->addColumn('created', 'datetime', [
            'default' => null,
            'null' => false,
        ]);
        $table->addColumn('modified', 'datetime', [
            'default' => null,
            'null' => false,
        ]);
        $table->create();
    }
}