<?php namespace App\Pages;

class Accounts 
{
    public $tabletitle = "Accounts Manager";
    public $pageclass = "accounts";
    public $pagesection = "accounts";
    public $model = "accounts";
    public $order = 'DESC';
    public $getentries = '/api/entries';
    public $entrycount = '/api/entriesinfo';
    public $putentry = '/api/saveuser';
    public $deleteentry = '/api/delete';
    public $showexportcsv = false;
    public $tablefields = [
        'ID'        => ['id'        => 'text'],
        'Username'  => ['username'  => 'text'],
        'Email'     => ['email'     => 'text'],
        'Groups'    => ['groups'    => 'text'],
    ];
    public $orderfields = [
        'ID'        => ['field' => 'id', 'selected' => true],
        'Username'  => ['field' => 'username'],
        'Groups'    => ['field' => 'groups'],
    ];
    public $searchfields = [
        'ID'        => 'users.id',
        'Username'  => 'users.username',
        'Email'     => 'users.email',
        'Groups'    => 'auth_groups.name',
    ];
    public $modals = [
        'create'    => [
            'title' => 'Create Account',
            'action_button' => 'Create',
            'close_button'  => 'Cancel',
            'elms'  => [
                [
                    'type'  => 'text',
                    'name'  => 'username',
                    'label' => 'Username',
                    'value' => '',
                    'required' => true
                ],
                [
                    'type'  => 'text',
                    'name'  => 'email',
                    'label' => 'Email',
                    'value' => '',
                    'required'  => true
                ],
                [
                    'type'  => 'sel',
                    'name'  => 'groups',
                    'label' => 'Type',
                    'value' => ['owner', 'staff'],
                    'required' => true
                ],
                [
                    'type'  => 'pass',
                    'name'  => 'password',
                    'label' => 'Password',
                    'required' => true
                ],
                [
                    'type'  => 'pass',
                    'name'  => 'pass_confirm',
                    'label' => 'ReEnter Password',
                    'required' => true
                ],
            ]
        ],
        'edit'      => [
            'title' => 'Edit Account',
            'action_button' => 'Edit',
            'close_button'  => 'Cancel',
            'elms'  => [
                [
                    'type'  => 'text',
                    'name'  => 'username',
                    'label' => 'Username',
                    'value' => '',
                    'required' => true,
                    'fill'  => 'username'
                ],
                [
                    'type'  => 'text',
                    'name'  => 'email',
                    'label' => 'Email',
                    'value' => '',
                    'required' => true,
                    'fill'  => 'email'
                ],
                [
                    'type'  => 'sel',
                    'name'  => 'groups',
                    'label' => 'Type',
                    'value' => ['owner', 'staff'],
                    'fill'  => 'groups'
                ],
                [
                    'type'  => 'button',
                    'label' => 'Change Password',
                    'onclick' => 'showChangePasswordModal(this)'
                ],
            ]
        ],
        'details' => [
            'title' => 'Account Details',
            'action_button' => null,
            'close_button'  => 'Close',
            'elms'  => [
                'Username' => ['field' => 'username', 'type' => 'text'],
                'Email' => ['field' => 'email', 'type' => 'text'],
                'Groups' => ['field' => 'groups', 'type' => 'text']
            ]
        ],
        'changepassword'      => [
            'title' => 'Change Password',
            'action_button' => 'Change',
            'close_button'  => 'Cancel',
            'elms'  => [
                [
                    'type'  => 'pass',
                    'name'  => 'password',
                    'label' => 'Password'
                ],
                [
                    'type'  => 'pass',
                    'name'  => 'pass_confirm',
                    'label' => 'ReEnter Password'
                ],
            ]
        ],
        'delete'    => [
            'title' => 'Delete Account',
            'action_button' => 'Delete',
            'close_button'  => 'Cancel',
            'elms'  => [
                [
                    'type' => 'label',
                    'value' => 'Do you really want to delete the account entry?',
                ]
            ]
        ]
    ];
}
