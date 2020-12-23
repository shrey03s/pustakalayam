<?php namespace App\Models;

use App\ExtendedModel;

/**
 * Description of CoalSuppliers
 *
 * @author rajnish
 */
class CoalSuppliersModel extends ExtendedModel
{
    protected $table = 'coal_suppliers';
    protected $primaryKey = 'id';
    
    protected $returnType = 'array';
    protected $availableFields = ['name', 'corpname', 'phone', 'email', 'gstin', 'address', 'city', 'state', 'country', 'area_pin', 'details'];
    protected $allowedFields = ['name', 'corpname', 'phone', 'email', 'gstin', 'address', 'city', 'state', 'country', 'area_pin', 'details', 'renter_id'];
    protected $useTimestamps = true;
    protected $useSoftDeletes = true;

    protected $validationRules    = [
        'name'          => 'required|min_length[1]|max_length[100]|string',
        'corpname'      => 'permit_empty|min_length[1]|max_length[100]|string',
        'phone'         => 'permit_empty|max_length[20]|alpha_numeric_punct',
        'email'         => 'permit_empty|max_length[255]|valid_email',
        'gstin'         => 'permit_empty|max_length[30]|alpha_numeric',
        'address'       => 'permit_empty|max_length[255]|string',
        'city'          => 'permit_empty|max_length[100]|string',
        'state'         => 'permit_empty|max_length[100]|string',
        'country'       => 'permit_empty|max_length[100]|string',
        'area_pin'      => 'permit_empty|max_length[10]|alpha_numeric',
        'details'       => 'permit_empty|valid_json',
        'renter_id'     => 'permit_empty|greater_than[0]|numeric',
    ];
    protected $validationMessages = [
        'name'  => [
            'required'      => "Coal Supplier's company/farm name is required!",
            'min_length'    => "Coal Supplier's company/farm name must have at least {param} characters!",
            'max_length'    => "Coal Supplier's company/farm name can not be more than {param} characters!",
            'string'        => "Coal Supplier's company/farm name contains illegal characters!"
        ],
        'corpname'  => [
            'required'      => "Coal Supplier's name is required!",
            'min_length'    => "Coal Supplier's name must have at least {param} characters!",
            'max_length'    => "Coal Supplier's name can not be more than {param} characters!",
            'string'        => "Coal Supplier's name contains illegal characters!"
        ],
        'phone' => [
            'max_length'    => "Coal Supplier's phone number can not be more than {param} digits!",
            'alpha_numeric_punct' => "Coal Supplier's phone number contains illegal characters!"
        ],
        'email' => [
            'max_length'    => "Coal Supplier's email can not be more than {param} characters!",
            'valid_email'   => "Coal Supplier's email must be a valid one!"
        ],
        'gstin' => [
            'max_length'    => "Coal Supplier's GSTIN can not be more than {param} characters!",
            'alpha_numeric' => "Coal Supplier's GSTIN contains illegal characters!"
        ],
        'address'   => [
            'max_length'    => "Coal Supplier's adresss must not be more than {param} characters!",
            'string'        => "Coal Supplier's address contains illegal characters!"
        ],
        'city' => [
            'max_length'    => "Coal Supplier's city name can not be more than {param} characters!",
            'string'        => "Coal Supplier's city name contains illegal characters!"
        ],
        'state' => [
            'max_length'    => "Coal Supplier's state name can not be more than {param} characters!",
            'string'        => "Coal Supplier's state name contains illegal characters!"
        ],
        'country' => [
            'max_length'    => "Coal Supplier's state name can not be more than {param} characters!",
            'string'        => "Coal Supplier's state name contains illegal characters!"
        ],
        'area_pin' => [
            'max_length'    => "Coal Supplier's area pincode can not be more than {param} characters!",
            'alpha_numeric' => "Coal Supplier's area pincode contains illegal characters!"
        ]
    ];
    protected $skipValidation     = false;
    
    protected $searchTableFields    = ['name', 'corpname','phone', 'email', 'gstin', 'address', 'city', 'state', 'country', 'area_pin', 'details'];
    protected $filterUFields        = ['name', 'corpname','phone', 'email', 'gstin', 'address', 'city', 'state', 'country', 'area_pin'];
    protected $orderTableFields     = ['name', 'corpname','phone', 'email', 'gstin' , 'city', 'state'];
    protected $topResultsFields     = ['name'];
    protected $editableFields = [
        'name'      => 'string',
        'corpname'  => 'string',
        'phone'     => 'string',
        'email'     => 'string',
        'gstin'     => 'string',
        'address'   => 'string',
        'city'      => 'string',
        'state'     => 'string',
        'country'   => 'string',
        'area_pin'  => 'string',
        'details'   => 'json'
    ];
    
    protected $exportFields = [
        'Name'              => ['field' => 'name', 'type' => 'string'],
        'Corp Name'         => ['field' => 'corpname', 'type' => 'string'],
        'Phone'             => ['field' => 'phone', 'type' => 'string'],
        'Email'             => ['field' => 'email', 'type' => 'string'],
        'GSTIN'             => ['field' => 'gstin', 'type' => 'string'],
        'Address'           => ['field' => 'address', 'type' => 'string'],
        'City'              => ['field' => 'city', 'type' => 'string'],
        'State'             => ['field' => 'state', 'type' => 'string'],
        'Country'           => ['field' => 'country', 'type' => 'string'],
        'Pin'               => ['field' => 'area_pin', 'type' => 'string'],
        'Other Details'     => ['field' => 'details', 'type' => 'string']
    ];
    
    protected function baseQueryBuilder() {
        return $this->builder()->select('id,`name`,corpname,phone,email,gstin,address,city,state,country,area_pin,details');
    }
}
