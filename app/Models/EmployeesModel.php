<?php namespace App\Models;

use App\ExtendedModel;

/**
 * Description of Employees
 *
 * @author rajnish
 */
class EmployeesModel extends ExtendedModel
{
    protected $table = 'employees';
    protected $primaryKey = 'id';
    
    protected $returnType = 'array';
    protected $availableFields = ['name', 'designation', 'department_id', 'phone', 'email', 'address', 'city', 'state', 'country', 'area_pin', 
        'salary_type', 'salary_amt', 'date', 'date_leaving'];
    protected $allowedFields = ['name', 'designation', 'department_id', 'phone', 'email', 'address', 'city', 'state', 'country', 'area_pin', 
        'salary_type', 'salary_amt', 'date', 'date_leaving'];
    protected $useTimestamps = true;
    protected $useSoftDeletes = true;

    protected $validationRules    = [
        'name'          => 'required|min_length[1]|max_length[100]|string',
        'designation'   => 'required|min_length[1]|max_length[100]|string',
        'department_id' => 'required|greater_than[0]|numeric',
        'phone'         => 'required|min_length[1]|max_length[20]|alpha_numeric_punct',
        'email'         => 'permit_empty|max_length[255]|valid_email',
        'address'       => 'permit_empty|max_length[255]|string',
        'city'          => 'permit_empty|max_length[100]|string',
        'state'         => 'permit_empty|max_length[100]|string',
        'country'       => 'permit_empty|max_length[100]|string',
        'area_pin'      => 'permit_empty|max_length[10]|alpha_numeric',
        'salary_type'   => 'required|min_length[1]|max_length[10]|alpha',
        'salary_amt'    => 'required|decimal',
        'date'          => 'required|valid_date',    # Date of joining
        'date_leaving'  => 'permit_empty|valid_date'
    ];
    protected $validationMessages = [
        'name'  => [
            'required'      => "Employee's name is required!",
            'min_length'    => "Employee's name must have at least {param} characters!",
            'max_length'    => "Employee's name can not be more than {param} characters!",
            'string'        => "Employee's name contains illegal characters!"
        ],
        'designation' => [
            'required'      => "Employee's designation is required!",
            'min_length'    => "Employee's designation must have at least {param} characters!",
            'max_length'    => "Employee's designation can not be more than {param} characters!",
            'string'        => "Employee's designation contains illegal characters!"
        ],
        'department_id' => [
            'required'      => "Department is required!",
            'greater_than'  => "Invalid Department selected!"
        ],
        'phone' => [
            'required'      => "Employee's phone number is required!",
            'min_length'    => "Employee's phone number must have at least {param} digits!",
            'max_length'    => "Employee's phone number can not be more than {param} digits!",
            'alpha_numeric_punct' => "Employee's phone number contains illegal characters!"
        ],
        'email' => [
            'max_length'    => "Employee's email can not be more than {param} characters!",
            'valid_email'   => "Employee's email must be a valid one!"
        ],
        'address'   => [
            'max_length'    => "Employee's adresss must not be more than {param} characters!",
            'string'        => "Employee's address contains illegal characters!"
        ],
        'city' => [
            'max_length'    => "Employee's city name can not be more than {param} characters!",
            'string'        => "Employee's city name contains illegal characters!"
        ],
        'state' => [
            'max_length'    => "Employee's state name can not be more than {param} characters!",
            'string'        => "Employee's state name contains illegal characters!"
        ],
        'country' => [
            'max_length'    => "Employee's state name can not be more than {param} characters!",
            'string'        => "Employee's state name contains illegal characters!"
        ],
        'area_pin' => [
            'min_length'    => "Employee's area pincode must have at least {param} characters!",
            'max_length'    => "Employee's area pincode can not be more than {param} characters!",
            'alpha_numeric' => "Employee's area pincode contains illegal characters!"
        ],
        'salary_type' => [
            'required'      => "Employee's salary type is required!",
            'min_length'    => "Employee's salary type is invalid!",
            'max_length'    => "Employee's salary type is invalid!",
            'alpha_numeric' => "Employee's salary type is invalid!"
        ],
        'salary_amt' => [
            'required'      => "Employee's salary amount is required!"
        ],
        'date' => [
            'required'      => "Employee's date of joining is required!"
        ]
    ];
    protected $skipValidation       = false;
    
    protected $searchJsonFields     = ['department.name'];
    protected $searchTableFields    = ['name', 'designation', 'address', 'city', 'state', 'country', 'area_pin', 'phone', 'email',
        'salary_type'];
    protected $filterDFields        = ['department_id', 'date','date_leaving'];
    protected $filterUFields        = ['name', 'designation', 'address', 'city', 'state', 'country', 'area_pin', 'phone', 'email', 'salary_type'];
    protected $topResultsFields     = ['name'];
    protected $orderJsonFields      = ['department.name'];
    protected $orderTableFields     = ['name', 'designation', 'city', 'state', 'country', 'phone', 'email', 'salary_type'];
    protected $editableFields = [
        'name'          => 'string',
        'designation'   => 'string',
        'department_id' => 'int',
        'phone'         => 'string',
        'email'         => 'string',
        'address'       => 'string',
        'city'          => 'string',
        'state'         => 'string',
        'country'       => 'string',
        'area_pin'      => 'string',
        'salary_type'   => 'string',
        'salary_amt'    => 'decimal',
        'date_leaving'  => 'date',
        'date'          => 'date',
    ];
    protected $publicFields = ['date_leaving'];
    protected $foreignFields = [
        'department_id'    => 'DepartmentTypesModel'
    ];
    
    protected $exportFields = [
        'Name'              => ['field' => 'name', 'type' => 'string'],
        'Designation'       => ['field' => 'designation', 'type' => 'string'],
        'Department'        => ['field' => 'department_id', 'type' => 'foreign', 'table' => 'department_types', 'tablefield' => 'name'],
        'Phone'             => ['field' => 'phone', 'type' => 'string'],
        'Email'             => ['field' => 'email', 'type' => 'string'],
        'Address'           => ['field' => 'address', 'type' => 'string'],
        'City'              => ['field' => 'city', 'type' => 'string'],
        'State'             => ['field' => 'state', 'type' => 'string'],
        'Country'           => ['field' => 'country', 'type' => 'string'],
        'Pin'               => ['field' => 'area_pin', 'type' => 'string'],
        'Salary Type'       => ['field' => 'salary_type', 'type' => 'string'],
        'Salary Amount'     => ['field' => 'salary_amt', 'type' => 'decimal'],
        'Date Joined'       => ['field' => 'date', 'type' => 'date'],
        'Date Left'         => ['field' => 'date_leaving', 'type' => 'date'],
    ];
    
    protected function baseQueryBuilder() {
        $selsql = "id,name,designation,(".$this->toJsonQuery('DepartmentTypesModel', 'employees.department_id').") as department,"
                . "phone,email,address,city,state,country,area_pin,"
                . "salary_type,salary_amt,`date`,`date_leaving`";
        
        return $this->builder()->select($selsql);
    }
}
