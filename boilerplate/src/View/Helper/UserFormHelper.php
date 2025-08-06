<?php
namespace App\View\Helper;

use Cake\View\Helper;

class UserFormHelper extends Helper
{
    public $helpers = ['Form'];

    /**
     * Render user form fields: email, password, role is optional.
     *
     * @param array $options Options like ['showRole' => true]
     * @return string
     */
    public function fields(array $options = [])
    {
        $html = '';

        $html .= $this->Form->control('email');
        $html .= $this->Form->control('password');

        if (!empty($options['showRole'])) {
            $html .= $this->Form->control('role', [
                'type' => 'select',
                'options' => ['user' => 'User', 'admin' => 'Admin'],
                'empty' => false
            ]);
        }

        return $html;
    }
}
