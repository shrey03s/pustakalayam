<?php namespace App\Models;

use App\ExtendedModel;

/**
 * Description of Vehicles
 *
 * @author rajnish
 */
class VehiclesModel extends ExtendedModel
{
    protected $table = 'vehicles';
    protected $primaryKey = 'id';
    
    protected $returnType = 'array';
    protected $availableFields = ['vin', 'type', 'date'];
    protected $allowedFields = ['vin', 'type', 'date'];
    protected $useTimestamps = true;
    protected $useSoftDeletes = true;

    protected $validationRules    = [
        'vin'   => 'required|min_length[1]|max_length[30]|alpha_numeric_punct|is_softunique[vehicles.vin,id,{id}]',
        'type'  => 'required|min_length[1]|max_length[30]|alpha_numeric_space', 
        'date'  => 'permit_empty|valid_date' // Date of purchase
    ];
    protected $validationMessages = [
        'vin' => [
            'is_softunique' => 'Sorry! The Vehicle Identification Number (VIN) is already registered!',
            'min_length' => 'Vehicle Identification Number (VIN) must be {param} digits!',
            'max_length' => 'Vehicle Identification Number (VIN) can not be more than {param} digits!',
            'required'   => 'Vehicle Identification Number (VIN) is required!',
            'alpha_numeric_punct' => 'Vehicle Identification Number (VIN) contains illegal characters!'
        ],
        'type' => [
            'required'      => 'Vehicle type is required!',
            'min_length'    => 'Vehicle type must be at least {param} characters!',
            'max_length'    => 'Vehicle type can not be more than {param} characters!',
            'alpha_numeric_space' => 'Vehicle type contains illegal characters!'
        ],
        'date' => [
            'required'   => 'Vehicle date of purchase is required!',
            'valid_date' => 'Vehicle date of purchase must be a valid date!'
        ]
    ];
    protected $skipValidation       = false;
    
    protected $searchTableFields    = ['vin', 'type'];
    protected $filterUFields        = ['vin', 'type'];
    protected $orderTableFields     = ['vin', 'type', 'date'];
    protected $topResultsFields     = ['vin'];
    protected $editableFields = [
        'vin'   => 'string',
        'type'  => 'string',
        'date'  => 'date'
    ];
    
    protected $exportFields = [
        'VIN'   => ['field' => 'vin', 'type' => 'string'],
        'Type'  => ['field' => 'type', 'type' => 'string'],
        'Date'  => ['field' => 'city', 'type' => 'date']
    ];
    
    protected function baseQueryBuilder() {
        return $this->builder()->select('id,vin,type,`date`');
    }
}
