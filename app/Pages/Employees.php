<?php namespace App\Pages;

/**
 * Description of Employees
 *
 * @author rajnish
 */
class Employees 
{
    public $tabletitle = "Employees Manager";
    public $pageclass = "employees";
    public $pagesection = "employees";
    public $model = 'employee';
    public $order = 'ASC';
    public $reqdata = true;
    public $getentries = "/api/entries";
    public $putentry = "/api/putentry";
    public $entrycount = '/api/entriesinfo';
    public $deleteentry = '/api/delete';
    
    public $tablefields = [
        'Name'              => ['name' => 'text'],
        'Designation'       => ['designation' => 'text'],
        'Department'        => ['department.name' => 'text'],
        'Phone'             => ['phone' => 'text'],
        'Email'             => ['email' => 'text'],
        'City'              => ['city' => 'text'],
        'Salary Type'       => ['salary_type' => 'text'],
        'Salary Amt'        => ['salary_amt' => 'decimal'],
        'Date Joined'       => ['date' => 'date'],
        'Date Leaving'      => ['date_leaving' => 'date']
    ];
    public $orderfields = [
        'Name'          => ['field' => 'name', 'selected' => true],
        'Designation'   => ['field' => 'designation'],
        'Department'    => ['field' => 'department.name'],
        'City'          => ['field' => 'city'],
        'State'         => ['field' => 'state'],
        'Phone'         => ['field' => 'phone'],
        'Email'         => ['field' => 'email'],
        'Salary Type'   => ['field' => 'salary_type']
    ];
    public $searchfields = [
        'Name'          => 'name',
        'Designation'   => 'designation',
        'Department'    => 'department.name',
        'Address'       => 'address',
        'City'          => 'city',
        'State'         => 'state',
        'Country'       => 'country',
        'Area Pin'      => 'area_pin',
        'Phone'         => 'phone',
        'Email'         => 'email',
        'Salary Type'   => 'salary_type'
    ];
    
    public $modals = [
        'create'    => [
            'title' => 'Add Employee',
            'action_button' => 'Add',
            'close_button'  => 'Cancel',
            'elms'  => [
                [
                    'type'  => 'text',
                    'name'  => 'name',
                    'label' => 'Name',
                    'value' => '',
                    'required' => true
                ],
                [
                    'type'  => 'text',
                    'name'  => 'designation',
                    'label' => 'Designation',
                    'value' => '',
                    'required' => true
                ],
                [
                    'type'  => 'varsel',
                    'name'  => 'department_id',
                    'label' => 'Department',
                    'url'   => '/api/topresults',
                    'model' => 'deparmentType',
                    'field' => 'name',
                    'createable' => true,
                    'required' => true
                ],
                [
                    'type'  => 'text',
                    'name'  => 'phone',
                    'label' => 'Phone',
                    'required' => true
                ],
                [
                    'type'  => 'text',
                    'name'  => 'email',
                    'label' => 'Email'
                ],
                [
                    'type'          => 'address',
                    'address_name'  => 'address',
                    'country_name'  => 'country',
                    'state_name'    => 'state',
                    'city_name'     => 'city',
                    'pin_name'      => 'area_pin'
                ],
                [
                    'type'  => 'sel',
                    'name'  => 'salary_type',
                    'label' => 'Salary Type',
                    'value' => ['DAILY','WEEKLY','MONTHLY'],
                    'selected' => 'MONTHLY',
                    'required' => true
                ],
                [
                    'type'  => 'number',
                    'name'  => 'salary_amt',
                    'label' => 'Salary Amount',
                    'required' => true
                ],
                [
                    'type'  => 'date',
                    'name'  => 'date',
                    'required' => true,
                    'label' => 'Date of Joining',
                ],
                [
                    'type'  => 'date',
                    'name'  => 'date_leaving',
                    'label' => 'Date of Leaving',
                    'filldate' => false,
                ]
            ]
        ],
        'edit'      => [
            'title' => 'Edit Employee',
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
                ],
                [
                    'type'  => 'text',
                    'name'  => 'designation',
                    'label' => 'Designation',
                    'value' => '',
                    'required' => true,
                    'fill'  => 'designation'
                ],
                [
                    'type'  => 'varsel',
                    'name'  => 'department_id',
                    'label' => 'Type',
                    'url'   => '/api/topresults',
                    'model' => 'deparmentType',
                    'field' => 'name',
                    'createable' => true,
                    'required' => true,
                    'fill'  => ['input' => 'department.name', 'hidden' => 'department.id']
                ],
                [
                    'type'  => 'text',
                    'name'  => 'phone',
                    'label' => 'Phone',
                    'fill'  => 'phone'
                ],
                [
                    'type'  => 'text',
                    'name'  => 'email',
                    'label' => 'Email',
                    'fill'  => 'email'
                ],
                [
                    'type'          => 'address',
                    'address_name'  => 'address',
                    'country_name'  => 'country',
                    'state_name'    => 'state',
                    'city_name'     => 'city',
                    'pin_name'      => 'area_pin',
                    'fill'          => [
                        'address'   => 'address',
                        'country'   => 'country',
                        'state'     => 'state',
                        'city'      => 'city',
                        'pin'       => 'area_pin'
                    ]
                ],
                [
                    'type'  => 'sel',
                    'name'  => 'salary_type',
                    'label' => 'Salary Type',
                    'value' => ['DAILY','WEEKLY','MONTHLY'],
                    'required' => true,
                    'fill'  => 'salary_type'
                ],
                [
                    'type'  => 'number',
                    'name' => 'salary_amt',
                    'label'  => 'Salary Amount',
                    'value' => '',
                    'required' => true,
                    'fill'  => 'salary_amt'
                ],
                [
                    'type'  => 'date',
                    'name'  => 'date',
                    'label' => 'Date of Joining',
                    'required' => true,
                    'fill'  => 'date'
                ],
                [
                    'type'  => 'date',
                    'name'  => 'date_leaving',
                    'label' => 'Date of Leaving',
                    'fill'  => 'date_leaving',
                    'filldate' => false,
                ]
            ]
        ],
        'filter' => [
            'title' => 'Filter Employees',
            'action_button' => 'Filter',
            'close_button' => 'Cancel',
            'elms' => [
                [
                    'type'  => 'text',
                    'name'  => 'name',
                    'label' => 'Name'
                ],
                [
                    'type'  => 'text',
                    'name'  => 'designation',
                    'label' => 'Designation'
                ],
                [
                    'type'  => 'varsel',
                    'name'  => 'department_id',
                    'label' => 'Department',
                    'url'   => '/api/topresults',
                    'model' => 'deparmentType',
                    'field' => 'name'
                ],
                [
                    'type'  => 'text',
                    'name'  => 'phone',
                    'label' => 'Phone'
                ],
                [
                    'type'  => 'text',
                    'name'  => 'email',
                    'label' => 'Email'
                ],
                [
                    'type'          => 'address',
                    'country_name'  => 'country',
                    'state_name'    => 'state',
                    'city_name'     => 'city',
                    'pin_name'      => 'area_pin'
                ],
                [
                    'type'  => 'text',
                    'name'  => 'salary_type',
                    'label' => 'Salary Type'
                ],
                [
                    'type'  => 'text',
                    'name'  => 'salary_amt',
                    'label' => 'Salary Amount'
                ],
                [
                    'type'  => 'date',
                    'name'  => 'date',
                    'label' => 'Date of Joining',
                ],
                [
                    'type'  => 'date',
                    'name'  => 'date_leaving',
                    'label' => 'Date of Leaving',
                ]
            ]
        ],
        'details' => [
            'title' => 'Employee Details',
            'action_button' => null,
            'close_button'  => 'Close',
            'elms'  => [
                'Name'              => ['field' => 'name', 'type' => 'text'],
                'Designation'       => ['field' => 'designation', 'type' => 'text'],
                'Departmant'        => ['field' => 'department.name', 'type' => 'text'],
                'Phone'             => ['field' => 'phone', 'type' => 'text'],
                'Email'             => ['field' => 'email', 'type' => 'text'],
                'Address'           => ['field' => 'address', 'type' => 'text'],
                'City'              => ['field' => 'city', 'type' => 'text'],
                'State'             => ['field' => 'state', 'type' => 'text'],
                'Country'           => ['field' => 'country', 'type' => 'text'],
                'Area Pin'          => ['field' => 'area_pin', 'type' => 'text'],
                'Salary Type'       => ['field' => 'salary_type', 'type' => 'text'],
                'Salary Amount'     => ['field' => 'salary_amt', 'type' => 'decimal'],
                'Date of Joining'   => ['field' => 'date', 'type' => 'date'],
                'Date of Leaving'   => ['field' => 'date_leaving', 'type' => 'date']
            ]
        ],
        'delete'    => [
            'title' => 'Delete Employee',
            'action_button' => 'Delete',
            'close_button'  => 'Cancel',
            'elms'  => [
                [
                    'type'  => 'label',
                    'value' => 'Do you really want to delete the Employee?',
                ]
            ]
        ]
    ];
}
