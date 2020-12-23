<?php namespace App\Models;

use App\ExtendedModel;

/**
 * Description of MineOrigin
 *
 * @author rajnish
 */
class AssetsTypeModel extends ExtendedModel
{
    protected $table = 'asset_types';
    protected $primaryKey = 'id';
    
    protected $returnType = 'array';
    protected $availableFields = ['name'];
    protected $allowedFields = ['name'];
    protected $useTimestamps = true;
    protected $useSoftDeletes = true;

    protected $validationRules    = [
        'name'  => 'required|min_length[1]|max_length[100]|string|is_softunique[asset_types.name,id,{id}]'
    ];
    protected $validationMessages = [
        'name'  => [
            'required'      => 'Asset type name is required!',
            'min_length'    => 'Asset type name must have at least {param} characters!',
            'max_length'    => 'Asset type name can not be more than {param} characters!',
            'string'        => 'Asset type name contains illegal characters!',
            'is_softunique' => 'The Asset type name `{value}` is already registered!'
        ]
    ];
    protected $skipValidation       = false;
    
    protected $searchTableFields    = ['name'];
    protected $filterUFields        = ['name'];
    protected $topResultsFields     = ['name'];
    protected $orderTableFields     = ['name'];
    protected $editableFields       = ['name' => 'string'];
    
    protected $exportFields = [
        'Name'              => ['field' => 'name', 'type' => 'string']
    ];
    
    protected function baseQueryBuilder() {
        return $this->builder()->select('id, `name`');
    }
}
