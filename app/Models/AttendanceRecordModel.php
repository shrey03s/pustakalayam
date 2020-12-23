<?php namespace App\Models;

use App\ExtendedModel;

/**
 * Description of AttendanceRecord
 *
 * @author rajnish
 */
class AttendanceRecordModel extends ExtendedModel
{
    protected $table = 'attendance_record';
    protected $primaryKey = 'id';
    
    protected $returnType = 'array';
    protected $availableFields = ['employee_id', 'is_present', 'reason', 'date'];
    protected $allowedFields = ['employee_id', 'is_present', 'reason', 'date'];
    protected $useTimestamps = true;
    protected $useSoftDeletes = false;

    protected $validationRules    = [
        'employee_id'   => 'required|greater_than[0]|numeric',
        'is_present'    => 'required|bool',
        'reason'        => 'permit_empty|string',
        'date'          => 'required|valid_date'
    ];
    protected $validationMessages = [
        'employee_id' => [
            'greater_than' => 'Invalid Employee selected!'
        ],
        'is_present' => [
            'required'      => "It's required to state if the employee was present!",
            'bool'          => "Invalid value for value of present or absent!"
        ]
    ];
    protected $skipValidation     = false;
    
    protected $searchJsonFields     = ['employee.name', 'employee.designation', 'employee.department', 'employee.address', 'employee.city', 'employee.state',
        'employee.country', 'employee.area_pin', 'employee.phone', 'employee.email', 'employee.salary_type'];
    protected $searchTableFields    = ['reason'];
    protected $searchBooleanFields  = ['is_present'];
    protected $filterDFields        = ['employee_id', 'is_present'];
    protected $filterNFields        = ['is_present'];
    protected $orderJsonFields      = ['employee.name'];
    protected $orderTableFields     = ['is_present', 'date'];
    protected $editableFields = [
        'employee_id'   => 'int',
        'is_present'    => 'bool',
        'reason'        => 'string',
        'date'          => 'date'
    ];
    protected $publicFields = ['is_present'];
    protected $foreignFields = [
        'employee_id'    => 'EmployeesModel'
    ];
    
    protected $statFields = [
        'present'    => "is_present"
    ];
    
    protected $exportFields = [
        'Employee'          => ['field' => 'employee_id', 'type' => 'foreign', 'table' => 'employees', 'tablefield' => 'name'],
        'Present'           => ['field' => 'is_present', 'type' => 'bool'],
        'Reason'            => ['field' => 'reason', 'type' => 'string'],
        'Date'              => ['field' => 'date', 'type' => 'date']
    ];
    
    protected function baseQueryBuilder() {
        $selsql = "id, (". $this->toJsonQuery('EmployeesModel', 'attendance_record.employee_id') .") as employee,"
                . "is_present, reason, `date`";
        
        return $this->builder()->select($selsql);
    }
    
    public function bulkQueryBuilder($date) {
        $db = $this->db;
        $builder = $db->table("employees emp")
                ->join("(SELECT employee_id FROM attendance_record WHERE date = CAST(". $db->escape($date) ." AS DATE)) att", "emp.id = att.employee_id", 'left');
        return $builder->select('emp.id,emp.`name`')->where("att.employee_id IS NULL AND emp.date_leaving IS NULL AND emp.deleted_at IS NULL");
    }
    
    public function getBulkEntryCount($date, $search = null)
    {
        $builder = $this->bulkQueryBuilder($date);
        
        if($search != null) {
            $builder->like('name', $search);
        }
        
        $count = db_connect()->query("SELECT COUNT(*) AS count FROM (".$builder->getCompiledSelect().") AS result;")->getRow();
        return $count;
    }
    
    public function getBulkEntries($date, $offset = 0, $count = 0, $search = null) {
        $builder = $this->bulkQueryBuilder($date)
                ->orderBy('name', 'ASC');
        
        if($search != null) {
            $builder->like('name', $search);
        }
        
        if($count > 0) {
            $builder->limit ($count, $offset);
        }
        
        return $builder->get()->getResult();
    }
    
    public function getPresentCount($emp, $fromdate, $todate) {
        $builder = $this->builder()->select('COUNT(*) as count')
                ->where("employee_id", $emp)
                ->where("is_present", 1)
                ->where("`date` BETWEEN CAST(". $this->db->escape($fromdate) ." AS DATE) AND "
                        . "CAST(". $this->db->escape($todate) ." AS DATE)");
        
        return $builder->get()->getRow();
    }
    
    public function getAbsentInfo($emp, $fromdate, $todate) {
        $builder = $this->builder()->select('`date`, reason')
                ->where("employee_id", $emp)
                ->where("is_present", 0)
                ->where("`date` BETWEEN CAST(". $this->db->escape($fromdate) ." AS DATE) AND "
                        ."CAST(". $this->db->escape($todate) ." AS DATE)");
        
        return $builder->get()->getResult();
    }
}
