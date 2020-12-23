<?php namespace App\Pages;

/**
 * Description of DepartmentType
 *
 * @author rajnish
 */
class DepartmentType
{
    public $tabletitle = "Department Types";
    public $pageclass = "departmenttypes";
    public $pagesection = "employees";
    public $model = "deparmentType";
    public $order = 'ASC';
    public $getentries = "/api/entries";
    public $putentry = "/api/putentry";
    public $entrycount = '/api/entriesinfo';
    public $deleteentry = '/api/delete';

    public $tablefields = [
        'Name'  => ['name' => 'text']
    ];
    public $orderfields = [
        'Name'  => ['field' => 'name']
    ];
    public $searchfields = [
        'Name'  => 'name'
    ];
    
    public $modals = [
        'create'    => [
            'title' => 'Create Department Type',
            'action_button' => 'Create',
            'close_button'  => 'Cancel',
            'elms'  => [
                [
                    'type'  => 'text',
                    'name'  => 'name',
                    'label' => 'Name',
                    'value' => '',
                    'required' => true
                ]
            ]
        ],
        'edit'      => [
            'title' => 'Edit Department Type',
            'action_button' => 'Edit',
            'close_button'  => 'Cancel',
            'elms'  => [
                [
                    'type'  => 'text',
                    'name'  => 'name',
                    'label' => 'Name',
                    'value' => '',
                    'required' => true,
                    'fill'  => 'name'
                ]
            ]
        ],
        'filter' => [
            'title' => 'Filter Department Types',
            'action_button' => 'Filter',
            'close_button' => 'Cancel',
            'elms' => [
                [
                    'type'  => 'text',
                    'name' => 'name',
                    'label' => 'Name'
                ]
            ]
        ],
        'details' => [
            'title' => 'Department Type Details',
            'action_button' => null,
            'close_button'  => 'Close',
            'elms'  => [
                'Name'  => ['field' => 'name', 'type' => 'text']
            ]
        ],
        'delete'    => [
            'title' => 'Delete Department Type',
            'action_button' => 'Delete',
            'close_button'  => 'Cancel',
            'elms'  => [
                [
                    'type' => 'label',
                    'value' => 'Do you really want to delete the department type?',
                ]
            ]
        ]
    ];
}
