<?php
use Migrations\AbstractMigration;

class AddWalletIdToLoans extends AbstractMigration
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
        $table = $this->table('loans');
        $table->addColumn('wallet_id', 'integer', ['null' => false])
            ->addForeignKey('wallet_id', 'wallets', 'id', [
                'delete' => 'CASCADE',
                'update' => 'NO_ACTION'
            ])
            ->update();
    }
}
