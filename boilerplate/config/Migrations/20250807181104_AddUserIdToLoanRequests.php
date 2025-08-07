<?php
use Migrations\AbstractMigration;

class AddUserIdToLoanRequests extends AbstractMigration
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
        $table = $this->table('loanRequests');
        $table->addColumn('user_id', 'integer', [
            'default' => null,
            'null' => false,
            'after' => 'id'
        ]);
        $table->update();
    }
}
