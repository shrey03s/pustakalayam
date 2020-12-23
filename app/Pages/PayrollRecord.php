<?php namespace App\Pages;

/**
 * Description of PayrollRecord
 *
 * @author rajnish
 */
class PayrollRecord 
{
    public $tabletitle = "Payroll Manager";
    public $pageclass = "payroll";
    public $pagesection = "payroll";
    public $model = 'payroll';
    public $order = 'DESC';
    public $getentries = "/api/entries";
    public $putentry = "/api/putentry";
    public $entrycount = '/api/entriesinfo';
    public $deleteentry = '/api/delete';
    
    public $tablefields = [
        'Employee'          => ['employee.name' => 'text'],
        'Attendance'        => ['attendance' => 'decimal'],
        'Salary Type'       => ['employee.salary_type' => 'text'],
        'Salary'            => ['payamt' => 'decimal'],
        'Time'              => ['timeamt' => 'number'],
        'Gross'             => ['gross_value' => 'decimal'],
        'Tax(%)'            => ['tax' => 'decimal'],
        'Addition'          => ['addition' => 'decimal'],
        'Deduction'         => ['deduction' => 'decimal'],
        'Net'               => ['net_value' => 'decimal'],
        'Date'              => ['date' => 'date']
    ];
    public $orderfields = [
        'Date'          => ['field' => 'date', 'selected' => true],
        'Employee'      => ['field' => 'employee.name'],
        'Salary Type'   => ['field' => 'employee.salary_type'],
        'Attendance'    => ['field' => 'attendance'],
        'Salary'        => ['field' => 'payamt'],
        'Time'          => ['field' => 'timeamt'],
        'Gross'         => ['field' => 'gross_value'],
        'Tax(%)'        => ['field' => 'tax'],
        'Addition'      => ['field' => 'addition'],
        'Deduction'     => ['field' => 'deduction'],
        'Net'           => ['field' => 'net_value']
    ];
    public $searchfields = [
        'Employee'              => 'employee.name',
        'Employee Designation'  => 'employee.designation',
        'Employee Department'   => 'employee.department.name',
        'Employee City'         => 'employee.city',
        'Employee State'        => 'employee.state',
        'Employee Phone'        => 'employee.phone',
        'Employee Email'        => 'employee.email',
        'Additions'             => 'addjson',
        'Deductions'            => 'dedjson'
    ];
    public $modals = [
        'create'    => [
            'title' => 'Create Payroll',
            'action_button' => 'Create',
            'close_button'  => 'Cancel',
            'elms'  => [
                [
                    'type'  => 'varsel',
                    'name'  => 'employee_id',
                    'id'    => 'payroll-create-employeeid',
                    'label' => 'Employee',
                    'url'   => '/api/topresults',
                    'model' => 'employee',
                    'field' => 'name',
                    'customevt' => 'fillLastPaymentDate',
                    'required' => true
                ],
                [
                    'type'  => 'date',
                    'name'  => '',
                    'id'    => 'payroll-create-frompay',
                    'label' => 'Pay From',
                    'filldate' => false,
                    'required' => true,
                    'onchange' => "fillAttendanceAndTime();"
                    . "setv('#payroll-create-gross', mul('#payroll-create-payamt', '#payroll-create-timeamt').toFixed(2));"
                    . "setv('#payroll-create-net', sub(sum(sub('#payroll-create-gross', "
                    . "(mul('#payroll-create-gross','#payroll-create-tax')/100)), tabval('#payroll-create-addition')), tabval('#payroll-create-deduction')));",
                ],
                [
                    'type'  => 'date',
                    'name'  => 'date',
                    'id'    => 'payroll-create-tillpay',
                    'label' => 'Pay At',
                    'onchange' => "fillAttendanceAndTime();"
                    . "setv('#payroll-create-gross', mul('#payroll-create-payamt', '#payroll-create-timeamt').toFixed(2));"
                    . "setv('#payroll-create-net', sub(sum(sub('#payroll-create-gross', "
                    . "(mul('#payroll-create-gross','#payroll-create-tax')/100)), tabval('#payroll-create-addition')), tabval('#payroll-create-deduction')));",
                    'filldate' => false,
                    'required' => true
                ],
                [
                    'type'  => 'text',
                    'name'  => '',
                    'label' => 'Salary Type',
                    'value' => '',
                    'id'    => 'payroll-create-period',
                    'fill'  => 'employee.salary_type',
                    'readonly' => true
                ],
                [
                    'type'  => 'text',
                    'name'  => 'timeamt',
                    'label' => 'Period (Salary Type x Period = Salary)',
                    'value' => 0,
                    'required' => true,
                    'readonly' => true,
                    'id'    => 'payroll-create-timeamt',
                    'onchange' => "setv('#payroll-create-gross', mul('#payroll-create-payamt', '#payroll-create-timeamt').toFixed(2));"
                    . "setv('#payroll-create-net', sub(sum(sub('#payroll-create-gross', "
                    . "(mul('#payroll-create-gross','#payroll-create-tax')/100)), tabval('#payroll-create-addition')), tabval('#payroll-create-deduction')));"
                ],
                [
                    'type'  => 'text',
                    'name'  => 'attendance',
                    'label' => 'Attendance',
                    'value' => 0,
                    'readonly' => true,
                    'id'    => 'payroll-create-attendance',
                    'required' => true
                ],
                [
                    'type'  => 'button',
                    'label' => 'Detail Attendance',
                    'onclick' => 'showAttendanceDetailModal(this)'
                ],
                [
                    'type'  => 'number',
                    'name'  => 'payamt',
                    'label' => 'Salary Amount',
                    'value' => '',
                    'required' => true,
                    'id'    => 'payroll-create-payamt',
                    'onchange' => "setv('#payroll-create-gross', mul('#payroll-create-payamt', '#payroll-create-timeamt').toFixed(2));"
                    . "setv('#payroll-create-net', sub(sum(sub('#payroll-create-gross', "
                    . "(mul('#payroll-create-gross','#payroll-create-tax')/100)), tabval('#payroll-create-addition')), tabval('#payroll-create-deduction')));"
                ],
                [
                    'type'  => 'calc',
                    'name'  => 'gross_value',
                    'label' => 'Gross Amount',
                    'value' => '0.00',
                    'id'    => 'payroll-create-gross'
                ],
                [
                    'type'  => 'number',
                    'name'  => 'tax',
                    'label' => 'Tax(%)',
                    'id'    => 'payroll-create-tax',
                    'onchange' => "setv('#payroll-create-net', sub(sum(sub('#payroll-create-gross', "
                    . "(mul('#payroll-create-gross','#payroll-create-tax')/100)), tabval('#payroll-create-addition')), tabval('#payroll-create-deduction')));"
                ],
                [
                    'type'      => 'table',
                    'name'      => 'addjson',
                    'id'    => 'payroll-create-addition',
                    'label'     => 'Additions',
                    'keytype'   => 'text',
                    'valuetype' => 'number',
                    'th'        => ['Type','Amount'],
                    'onchange' => "setv('#payroll-create-net', sub(sum(sub('#payroll-create-gross', "
                    . "(mul('#payroll-create-gross','#payroll-create-tax')/100)), tabval('#payroll-create-addition')), tabval('#payroll-create-deduction')));"
                ],
                [
                    'type'      => 'table',
                    'name'      => 'dedjson',
                    'id'    => 'payroll-create-deduction',
                    'label'     => 'Deductions',
                    'keytype'   => 'text',
                    'valuetype' => 'number',
                    'th'        => ['Type','Amount'],
                    'onchange' => "setv('#payroll-create-net', sub(sum(sub('#payroll-create-gross', "
                    . "(mul('#payroll-create-gross','#payroll-create-tax')/100)), tabval('#payroll-create-addition')), tabval('#payroll-create-deduction')));"
                ],
                [
                    'type'  => 'calc',
                    'name'  => 'net_value',
                    'label' => 'Net Amount',
                    'value' => '0.00',
                    'id'    => 'payroll-create-net',
                ]
            ]
        ],
        'edit'      => [
            'title' => 'Edit Payroll',
            'action_button' => 'Edit',
            'close_button'  => 'Cancel',
            'elms'  => [
                [
                    'type'  => 'text',
                    'label' => 'Employee',
                    'required' => true,
                    'readonly' => true,
                    'fill'  => 'employee.name'
                ],
                [
                    'type'  => 'date',
                    'name'  => 'date',
                    'id'    => 'payroll-edit-tillpay',
                    'label' => 'Paid At',
                    'filldate' => false,
                    'required' => true,
                    'readonly' => true,
                    'fill'  => 'date'
                ],
                [
                    'type'  => 'text',
                    'name'  => '',
                    'label' => 'Salary Type',
                    'value' => '',
                    'id'    => 'payroll-edit-period',
                    'fill'  => 'employee.salary_type',
                    'readonly' => true
                ],
                [
                    'type'  => 'text',
                    'name'  => 'timeamt',
                    'label' => 'Period (Salary Type x Period = Salary)',
                    'value' => 0,
                    'required' => true,
                    'readonly' => true,
                    'fill'  => 'timeamt',
                    'id'    => 'payroll-edit-timeamt'
                ],
                [
                    'type'  => 'text',
                    'name'  => 'attendance',
                    'label' => 'Attendance',
                    'value' => 0,
                    'readonly' => true,
                    'id'    => 'payroll-edit-attendance',
                    'required' => true,
                    'fill'  => 'attendance'
                ],
                [
                    'type'  => 'button',
                    'label' => 'Detail Attendance',
                    'onclick' => 'showAttendanceDetailModal(this)'
                ],
                [
                    'type'  => 'number',
                    'name'  => 'payamt',
                    'label' => 'Salary Amount',
                    'value' => '',
                    'required' => true,
                    'fill'  => 'payamt',
                    'id'    => 'payroll-edit-payamt',
                    'onchange' => "setv('#payroll-edit-gross', mul('#payroll-edit-payamt', '#payroll-edit-timeamt').toFixed(2));"
                    . "setv('#payroll-edit-net', sub(sum(sub('#payroll-edit-gross', "
                    . "(mul('#payroll-edit-gross','#payroll-edit-tax')/100)), tabval('#payroll-edit-addition')), tabval('#payroll-edit-deduction')));"
                ],
                [
                    'type'  => 'calc',
                    'name'  => 'gross_value',
                    'label' => 'Gross Amount',
                    'value' => '0.00',
                    'id'    => 'payroll-edit-gross',
                    'fill'  => 'gross_value'
                ],
                [
                    'type'  => 'number',
                    'name'  => 'tax',
                    'label' => 'Tax(%)',
                    'fill'  => 'tax',
                    'id'    => 'payroll-edit-tax',
                    'onchange' => "setv('#payroll-edit-net', sub(sum(sub('#payroll-edit-gross', "
                    . "(mul('#payroll-edit-gross','#payroll-edit-tax')/100)), tabval('#payroll-edit-addition')), tabval('#payroll-edit-deduction')));"
                ],
                [
                    'type'      => 'table',
                    'name'      => 'addjson',
                    'id'    => 'payroll-edit-addition',
                    'label'     => 'Additions',
                    'keytype'   => 'text',
                    'valuetype' => 'number',
                    'th'        => ['Type','Amount'],
                    'fill'      => ['table' => 'addjson', 'hidden' => 'addjson'],
                    'onchange' => "setv('#payroll-edit-net', sub(sum(sub('#payroll-edit-gross', "
                    . "(mul('#payroll-edit-gross','#payroll-edit-tax')/100)), tabval('#payroll-edit-addition')), tabval('#payroll-edit-deduction')));"
                ],
                [
                    'type'      => 'table',
                    'name'      => 'dedjson',
                    'id'    => 'payroll-edit-deduction',
                    'label'     => 'Deductions',
                    'keytype'   => 'text',
                    'valuetype' => 'number',
                    'th'        => ['Type','Amount'],
                    'fill'      => ['table' => 'dedjson', 'hidden' => 'dedjson'],
                    'onchange' => "setv('#payroll-edit-net', sub(sum(sub('#payroll-edit-gross', "
                    . "(mul('#payroll-edit-gross','#payroll-edit-tax')/100)), tabval('#payroll-edit-addition')), tabval('#payroll-edit-deduction')));"
                ],
                [
                    'type'  => 'calc',
                    'name'  => 'net_value',
                    'label' => 'Net Amount',
                    'value' => '0.00',
                    'id'    => 'payroll-edit-net',
                    'fill'  => 'net_value'
                ]
            ]
        ],
        'filter' => [
            'title' => 'Filter Payroll Entries',
            'action_button' => 'Filter',
            'close_button' => 'Cancel',
            'elms' => [
                [
                    'type'  => 'varsel',
                    'name'  => 'employee_id',
                    'label' => 'Employee',
                    'url'   => '/api/topresults',
                    'model' => 'employee',
                    'field' => 'name'
                ],
                [
                    'type'  => 'text',
                    'name'  => 'attendance',
                    'label' => 'Attendance'
                ],
                [
                    'type'  => 'text',
                    'name'  => 'payamt',
                    'label' => 'Salary Amount'
                ],
                [
                    'type'  => 'text',
                    'name'  => 'timeamt',
                    'label' => 'Time'
                ],
                [
                    'type'  => 'text',
                    'name'  => 'gross_value',
                    'label' => 'Gross Amount'
                ],
                [
                    'type'  => 'text',
                    'name'  => 'tax',
                    'label' => 'Tax(%)'
                ],
                [
                    'type'  => 'text',
                    'name'  => 'addition',
                    'label' => 'Additions'
                ],
                [
                    'type'  => 'text',
                    'name'  => 'deduction',
                    'label' => 'Deductions'
                ],
                [
                    'type'  => 'text',
                    'name'  => 'net_value',
                    'label' => 'Net Amount'
                ]
            ],
        ],
        'attendance' => [
            'title' => 'Absent Details',
            'action_button' => null,
            'close_button' => 'Close',
            'putareaid' => 'attendetails',
            'elms' => []
        ],
        'details' => [
            'title' => 'Payroll Enrtry Details',
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
                    'Salary Amount'     => ['field' => 'employee.salary_amt', 'type' => 'deimal'],
                    'Date of Joining'   => ['field' => 'employee.date', 'type' => 'date'],
                    'Date of Leaving'   => ['field' => 'employee.date_leaving', 'type' => 'date'],
                ],
                'Attendance'            => ['field' => 'attendance', 'type' => 'number'],
                'Salary'                => ['field' => 'payamt', 'type' => 'decimal'],
                'Time'                  => ['field' => 'timeamt', 'type' => 'decimal'],
                'Gross Amount'          => ['field' => 'gross_value', 'type' => 'decimal'],
                'Tax'                   => ['field' => 'tax', 'type' => 'decimal'],
                'Additions'             => ['field' => 'addition', 'type' => 'decimal'],
                'Additions Details'     => ['field' => 'addjson', 'type' => 'json'],
                'Deductions'            => ['field' => 'deduction', 'type' => 'decimal'],
                'Deductions Details'    => ['field' => 'dedjson', 'type' => 'json'],
                'Net Amount'            => ['field' => 'net_value', 'type' => 'decimal'],
                'Date'                  => ['field' => 'date', 'type' => 'date']
            ]
        ],
        'delete'    => [
            'title' => 'Delete Payroll Entry',
            'action_button' => 'Delete',
            'close_button'  => 'Cancel',
            'elms'  => [
                [
                    'type'  => 'label',
                    'value' => 'Do you really want to delete the payroll entry?',
                ]
            ]
        ]
    ];
}
