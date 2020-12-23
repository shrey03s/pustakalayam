<?php namespace App\Models;

use App\ExtendedModel;

/**
 * Description of RentCustomers
 *
 * @author rajnish
 */
class RentersModel extends ExtendedModel
{
    protected $table = 'renters';
    protected $primaryKey = 'id';
    
    protected $returnType = 'array';
    protected $availableFields = ['name', 'profession', 'phone', 'email', 'address', 'city', 'state', 'country', 'area_pin', 'details'];
    protected $allowedFields = ['name', 'profession', 'phone', 'email', 'address', 'city', 'state', 'country', 'area_pin', 'details'];
    protected $useTimestamps = true;
    protected $useSoftDeletes = true;

    protected $validationRules    = [
        'name'          => 'required|min_length[1]|max_length[100]|string',
        'profession'    => 'permit_empty|max_length[100]|string',
        'phone'         => 'permit_empty|max_length[20]|alpha_numeric_punct',
        'email'         => 'permit_empty|max_length[255]|valid_email',
        'address'       => 'permit_empty|max_length[255]|string',
        'city'          => 'permit_empty|max_length[100]|string',
        'state'         => 'permit_empty|max_length[100]|string',
        'country'       => 'permit_empty|max_length[100]|string',
        'area_pin'      => 'permit_empty|max_length[10]|alpha_numeric',
        'details'       => 'permit_empty|valid_json'
    ];
    protected $validationMessages = [
        'name'  => [
            'required'      => "Vehicle Renter's name is required!",
            'min_length'    => "Vehicle Renter's name must have at least {param} characters!",
            'max_length'    => "Vehicle Renter's name can not be more than {param} characters!",
            'string'        => "Vehicle Renter's name contains illegal characters!"
        ],
        'profession'    => [
            'max_length'    => "Vehicle Renter's profession can not be more than {param} characters!",
            'string'        => "Vehicle Renter's profession contains illegal characters!"
        ],
        'phone' => [
            'max_length'    => "Vehicle Renter's phone number can not be more than {param} digits!",
            'alpha_numeric_punct' => "Vehicle Renter's phone number contains illegal characters!"
        ],
        'email' => [
            'max_length'    => "Vehicle Renter's email can not be more than {param} characters!",
            'valid_email'   => "Vehicle Renter's email must be a valid one!"
        ],
        'address'   => [
            'max_length'    => "Vehicle Renter's adresss must not be more than {param} characters!",
            'string'        => "Vehicle Renter's address contains illegal characters!"
        ],
        'city' => [
            'max_length'    => "Vehicle Renter's city name can not be more than {param} characters!",
            'string'        => "Vehicle Renter's city name contains illegal characters!"
        ],
        'state' => [
            'max_length'    => "Vehicle Renter's state name can not be more than {param} characters!",
            'string'        => "Vehicle Renter's state name contains illegal characters!"
        ],
        'country' => [
            'max_length'    => "Vehicle Renter's state name can not be more than {param} characters!",
            'string'        => "Vehicle Renter's state name contains illegal characters!"
        ],
        'area_pin' => [
            'max_length'    => "Vehicle Renter's area pincode can not be more than {param} characters!",
            'alpha_numeric' => "Vehicle Renter's area pincode contains illegal characters!"
        ]
    ];
    protected $skipValidation     = false;
    
    protected $searchTableFields    = ['name', 'profession', 'phone', 'email', 'address', 'city', 'state', 'country', 'area_pin', 'details'];
    protected $filterUFields        = ['name', 'profession', 'phone', 'email', 'address', 'city', 'state', 'country', 'area_pin'];
    protected $topResultsFields     = ['name'];
    protected $orderTableFields     = ['name', 'profession', 'phone', 'email', 'city', 'state'];
    protected $editableFields = [
        'name'      => 'string',
        'profession'=> 'string',
        'phone'     => 'string',
        'email'     => 'string',
        'address'   => 'string',
        'city'      => 'string',
        'state'     => 'string',
        'country'   => 'string',
        'area_pin'  => 'string',
        'details'   => 'json'
    ];
    
    protected $exportFields = [
        'Name'              => ['field' => 'name', 'type' => 'string'],
        'Profession'        => ['field' => 'profession', 'type' => 'string'],
        'Phone'             => ['field' => 'phone', 'type' => 'string'],
        'Email'             => ['field' => 'email', 'type' => 'string'],
        'Address'           => ['field' => 'address', 'type' => 'string'],
        'City'              => ['field' => 'city', 'type' => 'string'],
        'State'             => ['field' => 'state', 'type' => 'string'],
        'Country'           => ['field' => 'country', 'type' => 'string'],
        'Pin'               => ['field' => 'area_pin', 'type' => 'string'],
        'Other Details'     => ['field' => 'details', 'type' => 'string']
    ];
    
    protected function baseQueryBuilder() {
        return $this->builder()->select('id,`name`,profession,phone,email,address,city,state,country,area_pin,details');
    }
}
