<?php namespace App\Pages;

/**
 * Description of AttendanceRecord
 *
 * @author rajnish
 */
class AttendanceRecord 
{
    public $tabletitle = "Attendance Manager";
    public $pageclass = "attendance";
    public $pagesection = "attendance";
    public $model = "attendance";
    public $order = 'DESC';
    public $getentries = "/api/entries";
    public $putentry = "/api/putentry";
    public $entrycount = '/api/entriesinfo';
    public $deleteentry = '/api/delete';
    
    public $tablefields = [
        'Employee'          => ['employee.name' => 'text'],
        'Present/Absent'    => ['is_present' => 'bool'],
        'Reason'            => ['reason' => 'text'],
        'Date'              => ['date' => 'date']
    ];
    public $orderfields = [
        'Date'      => ['field' => 'date', 'selected' => true],
        'Employee'  => ['field' => 'employee.name'],
        'Present'   => ['field' => 'is_present']
    ];
    public $searchfields = [
        'Employee'              => 'employee.name',
        'Employee Designation'  => 'employee.designation',
        'Employee Department'   => 'employee.department.name',
        'Employee City'         => 'employee.city',
        'Employee State'        => 'employee.state',
        'Employee Phone'        => 'employee.phone',
        'Employee Email'        => 'employee.email',
        'Present'               => 'is_present',
        'Absent'                => '!is_present',
        'Reason'                => 'reason'
    ];
    public $modals = [
        'create'    => [
            'title' => 'Add Attendance',
            'action_button' => 'Add',
            'close_button'  => 'Cancel',
            'elms'  => [
                [
                    'type'  => 'varsel',
                    'name'  => 'employee_id',
                    'label' => 'Employee',
                    'url'   => '/api/topresults',
                    'model' => 'employee',
                    'field' => 'name',
                    'required' => true
                ],
                [
                    'type'  => 'check',
                    'name'  => 'is_present',
                    'label' => 'Present',
                    'required' => true
                ],
                [
                    'type'  => 'textarea',
                    'name'  => 'reason',
                    'label' => 'Reason',
                    'value' => '',
                    'placeholder' => 'Reason..'
                ],
                [
                    'type'  => 'date',
                    'name'  => 'date',
                    'label' => 'Date',
                    'required' => true
                ]
            ]
        ],
        'edit'      => [
            'title' => 'Edit Attendance',
            'action_button' => 'Edit',
            'close_button'  => 'Cancel',
            'elms'  => [
                [
                    'type'  => 'varsel',
                    'name'  => 'employee_id',
                    'label' => 'Employee',
                    'url'   => '/api/topresults',
                    'model' => 'employee',
                    'field' => 'name',
                    'required' => true,
                    'fill'  => ['input' => 'employee.name', 'hidden' => 'employee.id']
                ],
                [
                    'type'  => 'check',
                    'name'  => 'is_present',
                    'label' => 'Present',
                    'required' => true,
                    'fill'  => 'is_present'
                ],
                [
                    'type'  => 'textarea',
                    'name'  => 'reason',
                    'label' => 'Reason',
                    'value' => '',
                    'placeholder' => 'Reason..',
                    'fill'  => 'reason'
                ],
                [
                    'type'  => 'date',
                    'name'  => 'date',
                    'label' => 'Date',
                    'fill'  => 'date',
                    'required' => true
                ]
            ]
        ],
        'filter' => [
            'title' => 'Filter Attendance',
            'action_button' => 'Filter',
            'close_button' => 'Cancel',
            'elms' => [
                [
                    'type'  => 'varsel',
                    'name'  => 'employee_id',
                    'label' => 'Employee',
                    'url'   => '/api/topresults',
                    'model' => 'employee',
                    'field' => 'name',
                ],
                [
                    'type'  => 'check',
                    'name'  => 'is_present',
                    'label' => 'Present'
                ]
            ]
        ],
        'details' => [
            'title' => 'Attendance Entry Details',
            'action_button' => null,
            'close_button'  => 'Close',
            'elms'  => [
                'Employee' => [
                    'head'              => ['field' => 'employee.name', 'type' => 'text'],
                    'Designation'       => ['field' => 'employee.designation', 'type' => 'text'],
                    'Departmant'        => ['field' => 'employee.department.name', 'type' => 'text'],
                    'Phone'             => ['field' => 'employee.phone', 'type' => 'text'],
                    'Email'             => ['field' => 'employee.email', 'type' => 'text'],
                    'Address'           => ['field' => 'employee.address', 'type' => 'text'],
                    'City'              => ['field' => 'employee.city', 'type' => 'text'],
                    'State'             => ['field' => 'employee.state', 'type' => 'text'],
                    'Country'           => ['field' => 'employee.country', 'type' => 'text'],
                    'Area Pin'          => ['field' => 'employee.area_pin', 'type' => 'text'],
                    'Salary Type'       => ['field' => 'employee.salary_type', 'type' => 'text'],
                    'Salary Amount'     => ['field' => 'employee.salary_amt', 'type' => 'decimal'],
                    'Date of Joining'   => ['field' => 'employee.date', 'type' => 'date'],
                    'Date of Leaving'   => ['field' => 'employee.date_leaving', 'type' => 'date']
                ],
                'Present'   => ['field' => 'is_present', 'type' => 'bool'],
                'Reason'    => ['field' => 'reason', 'type' => 'text'],
                'Date'      => ['field' => 'date', 'type' => 'date']
            ]
        ],
        'delete'    => [
            'title' => 'Delete Attendance',
            'action_button' => 'Delete',
            'close_button'  => 'Cancel',
            'elms'  => [
                [
                    'type' => 'label',
                    'value' => 'Do you really want to delete the attendance entry?',
                ]
            ]
        ]
    ];
}
