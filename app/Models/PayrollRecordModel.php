<?php namespace App\Models;

use App\ExtendedModel;

/**
 * Description of SalaryRecordModel
 *
 * @author rajnish
 */
class PayrollRecordModel extends ExtendedModel
{
    protected $table = 'payroll_record';
    protected $primaryKey = 'id';
    
    protected $returnType = 'array';
    protected $availableFields = ['employee_id', 'attendance', 'payamt', 'timeamt', 'ROUND((`payamt`*`timeamt`),2) AS gross_value', 'tax', 'addjson',
        '(JSON_ARRSUM(JSON_EXTRACT(addjson, \'$.*\'))) AS addition', 'dedjson', '(JSON_ARRSUM(JSON_EXTRACT(dedjson, \'$.*\'))) AS deduction', 
        "ROUND(((`payamt`*`timeamt`) - (((`payamt`*`timeamt`)*`tax`)/100) + (JSON_ARRSUM(JSON_EXTRACT(addjson, '$.*'))) - (JSON_ARRSUM(JSON_EXTRACT(dedjson, '$.*')))),2) AS net_value",
        'date'];
    protected $allowedFields = ['employee_id', 'attendance', 'payamt', 'timeamt', 'tax', 'addjson', 'dedjson','date'];
    protected $useTimestamps = true;
    protected $useSoftDeletes = false;

    protected $validationRules    = [
        'employee_id'   => 'required|greater_than[0]|numeric',
        'attendance'    => 'required|numeric',
        'payamt'        => 'required|decimal',
        'timeamt'       => 'required|decimal',
        'tax'           => 'permit_empty|decimal',
        'addjson'       => 'permit_empty|valid_json',
        'dedjson'       => 'permit_empty|valid_json',
        'date'          => 'required|valid_date'
    ];
    protected $validationMessages = [
        'employee_id' => [
            'required'      => 'Employee is required!',
            'greater_than'  => 'Invalid Employee selected!'
        ],
        'attendance' => [
            'required'      => 'The attendance is required!'
        ],
        'payamt' => [
            'required'      => 'The amount of periodic salary payable is required!'
        ],
        'timeamt' => [
            'required'      => 'The amount of time for wages is required!'
        ]
    ];
    protected $skipValidation     = false;
    
    protected $searchJsonFields = ['employee.name', 'employee.designation', 'employee.department', 'employee.address', 'employee.city', 'employee.state',
        'employee.country', 'employee.area_pin', 'employee.phone', 'employee.email', 'employee.salary_type'];
    protected $searchTableFields = ['addjson', 'dedjson'];
    protected $filterDFields    = ['employee_id'];
    protected $filterNFields    = ['attendance','payamt','timeamt','gross_value','tax','addition','deduction','net_value'];
    protected $orderJsonFields  = ['employee.name', 'employee.salary_type'];
    protected $orderTableFields = ['attendance', 'payamt', 'timeamt', 'gross_value', 'tax', 'net_value', 'addition', 'deduction', 'date'];
    protected $editableFields = [
        'employee_id'   => 'int',
        'attendance'    => 'int',
        'payamt'        => 'decimal',
        'timeamt'       => 'decimal',
        'tax'           => 'decimal',
        'addjson'       => 'json',
        'dedjson'       => 'json',
        'date'          => 'date'
    ];
    protected $foreignFields = [
        'employee_id'    => 'EmployeesModel'
    ];
    protected $sumableFields = ['payamt', 'gross_value', 'addition', 'deduction', 'net_value'];
    
    protected $statFields = [
        'expenses'    => "ROUND(((`payamt`*`timeamt`)- (((`payamt`*`timeamt`)*`tax`)/100) + "
        . "(JSON_ARRSUM(JSON_EXTRACT(addjson, '$.*'))) - (JSON_ARRSUM(JSON_EXTRACT(dedjson, '$.*')))),2)"
    ];
    
    protected $exportFields = [
        'Employee'          => ['field' => 'employee_id', 'type' => 'foreign', 'table' => 'employees', 'tablefield' => 'name'],
        'Attendance'        => ['field' => 'attendance', 'type' => 'integer'],
        'Salary'            => ['field' => 'payamt', 'type' => 'decimal'],
        'Period'            => ['field' => 'timeamt', 'type' => 'decimal'],
        'Gross'             => ['field' => 'gross_value', 'type' => 'decimal'],
        'Tax'               => ['field' => 'tax', 'type' => 'decimal'],
        'Addition'          => ['field' => 'addition', 'type' => 'decimal'],
        'Deduction'         => ['field' => 'deduction', 'type' => 'decimal'],
        'Net'               => ['field' => 'net_value', 'type' => 'decimal'],
        'Date'              => ['field' => 'date', 'type' => 'date']
    ];
    
    protected function baseQueryBuilder() {
        $selsql = "id, (". $this->toJsonQuery('EmployeesModel', 'payroll_record.employee_id').") as employee,"
                . "attendance,payamt,timeamt,ROUND((`payamt`*`timeamt`),2) AS gross_value,tax,addjson,(JSON_ARRSUM(JSON_EXTRACT(addjson, '$.*'))) AS addition,"
                . "dedjson,(JSON_ARRSUM(JSON_EXTRACT(dedjson, '$.*'))) AS deduction,"
                . "ROUND(((`payamt`*`timeamt`)- (((`payamt`*`timeamt`)*`tax`)/100) + (JSON_ARRSUM(JSON_EXTRACT(addjson, '$.*'))) "
                . "- (JSON_ARRSUM(JSON_EXTRACT(dedjson, '$.*')))),2) AS net_value,`date`";
        
        return $this->builder()->select($selsql);
    }
    
    public function getLastPayment($emp) {
        $builder = $this->builder()->select('date as lastdate')
                ->where('employee_id', $emp)
                ->orderBy('date', 'DESC')
                ->limit(1, 0);
        
        return $builder->get()->getRow();
    }
}
