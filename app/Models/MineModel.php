<?php namespace App\Models;

use App\ExtendedModel;

/**
 * Description of MineOrigin
 *
 * @author rajnish
 */
class MineModel extends ExtendedModel
{
    protected $table = 'mine';
    protected $primaryKey = 'id';
    
    protected $returnType = 'array';
    protected $availableFields = ['name', 'address', 'city', 'state', 'country', 'area_pin'];
    protected $allowedFields = ['name', 'address', 'city', 'state', 'country', 'area_pin'];
    protected $useTimestamps = true;
    protected $useSoftDeletes = true;

    protected $validationRules    = [
        'name'          => 'required|min_length[1]|max_length[100]|string|is_softunique[mine.name,id,{id}]',
        'address'       => 'permit_empty|max_length[255]|string',
        'city'          => 'permit_empty|max_length[100]|string',
        'state'         => 'permit_empty|max_length[100]|string',
        'country'       => 'permit_empty|max_length[100]|string',
        'area_pin'      => 'permit_empty|max_length[10]|alpha_numeric'
    ];
    protected $validationMessages = [
        'name'  => [
            'required'      => "Mine's name is required!",
            'min_length'    => "Mine's name must have at least {param} characters!",
            'max_length'    => "Mine's name can not be more than {param} characters!",
            'string'        => "Mine's name contains illegal characters!",
            'is_softunique' => "The Mine's name `{value}` is already registered!"
        ],
        'address'   => [
            'max_length'    => "Mine's adresss must not be more than {param} characters!",
            'string'        => "Mine's address contains illegal characters!"
        ],
        'city' => [
            'max_length'    => "Mine's city name can not be more than {param} characters!",
            'string'        => "Mine's city name contains illegal characters!"
        ],
        'state' => [
            'max_length'    => "Mine's state name can not be more than {param} characters!",
            'string'        => "Mine's state name contains illegal characters!"
        ],
        'country' => [
            'max_length'    => "Mine's state name can not be more than {param} characters!",
            'string'        => "Mine's state name contains illegal characters!"
        ],
        'area_pin' => [
            'max_length'    => "Mine's area pincode can not be more than {param} characters!",
            'alpha_numeric' => "Mine's area pincode contains illegal characters!"
        ]
    ];
    protected $skipValidation     = false;
    
    protected $searchTableFields    = ['name', 'city', 'state', 'country', 'area_pin'];
    protected $filterUFields        = ['name', 'city', 'state', 'country', 'area_pin'];
    protected $orderTableFields     = ['name', 'city', 'state'];
    protected $topResultsFields     = ['name'];
    protected $editableFields = [
        'name'      => 'string',
        'address'   => 'string',
        'city'      => 'string',
        'state'     => 'string',
        'country'   => 'string',
        'area_pin'  => 'string'
    ];
    
    protected $exportFields = [
        'Name'              => ['field' => 'name', 'type' => 'string'],
        'Address'           => ['field' => 'address', 'type' => 'string'],
        'City'              => ['field' => 'city', 'type' => 'string'],
        'State'             => ['field' => 'state', 'type' => 'string'],
        'Country'           => ['field' => 'country', 'type' => 'string'],
        'Pin'               => ['field' => 'area_pin', 'type' => 'string']
    ];
    
    protected function baseQueryBuilder() {
        return $this->builder()->select('id, `name`, address, city, state, country, area_pin');
    }
}
