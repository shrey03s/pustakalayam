<?php namespace App\Models;

use App\ExtendedModel;

/**
 * Description of AssetsRecord
 *
 * @author rajnish
 */
class AssetsRecordModel extends ExtendedModel
{
    protected $table = 'assets_record';
    protected $primaryKey = 'id';
    
    protected $returnType = 'array';
    protected $availableFields = ['newstock', 'type_id', 'name', 'amount', 'rate', 'cost', 'usedamt', 'stockamt', 'depot_id', 'details', 'desc', 'date'];
    protected $allowedFields = ['newstock', 'type_id', 'name', 'amount', 'rate', 'usedamt', 'depot_id', 'details', 'desc', 'date'];
    protected $useTimestamps = true;
    protected $useSoftDeletes = false;

    protected $validationRules    = [
        'newstock'      => 'required|bool',
        'type_id'       => 'required|greater_than[0]|numeric',
        'name'          => 'required|min_length[1]|max_length[100]|string',
        'amount'        => 'required|decimal',
        'rate'          => 'permit_empty|decimal',
        'usedamt'       => 'required|decimal',
        'depot_id'      => 'required|greater_than[0]|numeric',
        'details'       => 'permit_empty|valid_json',
        'desc'          => 'permit_empty|string',
        'date'          => 'required|valid_date'
    ];
    protected $validationMessages = [
        'newstock' => [
            'required'      => "It's required to state if the asset is a new stock or using the old stock!",
            'bool'          => "Invalid value for value of stock or used!"
        ],
        'type_id' => [
            'required'      => "Asset's type is required!",
            'greater_than'  => 'Invalid Asset Type!'
        ],
        'name'  => [
            'required'      => "Asset's name is required!",
            'min_length'    => "Asset's name must have at least {param} characters!",
            'max_length'    => "Asset's name can not be more than {param} characters!",
            'string'        => 'Asset\'s name contains illegal characters!'
        ],
        'amount' => [
            'required'  => 'The amount of the given asset is required!',
            'decimal'   => 'Illegal characters in `amount`!'
        ],
        'rate' => [
            'required'  => 'The total rate of cost of the given asset for the amount required!',
            'decimal'   => 'Illegal characters in `rate`!'
        ],
        'usedamt' => [
            'required'  => 'The amount of the given asset is required!',
            'decimal'   => 'Illegal characters in `amount`!'
        ],
        'depot_id' => [
            'required'     => "Asset's depot is required!",
            'greater_than' => 'Invalid Depot selected!'
        ]
    ];
    protected $skipValidation       = false;
    
    protected $searchJsonFields     = ['type.name', 'depot.name','depot.incharge', 'depot.city', 'depot.state', 'depot.area_pin'];
    protected $searchTableFields    = ['name', 'details', 'desc'];
    protected $searchBooleanFields  = ['newstock'];
    protected $filterDFields        = ['type_id', 'depot_id'];
    protected $filterNFields        = ['newstock', 'amount', 'rate', 'cost', 'usedamt', 'stockamt'];
    protected $filterUFields        = ['name'];
    protected $orderJsonFields      = ['type.name', 'depot.name'];
    protected $orderTableFields     = ['newstock', 'name', 'amount', 'rate', 'cost', 'usedamt', 'stockamt', 'date'];
    protected $editableFields = [
        'newstock'  => 'bool',
        'type_id'   => 'int',
        'name'      => 'string',
        'amount'    => 'decimal',
        'rate'      => 'decimal',
        'usedamt'   => 'decimal',
        'depot_id'  => 'int',
        'details'   => 'json',
        'desc'      => 'string',
        'date'      => 'date'
    ];
    protected $foreignFields = [
        'type_id'       => 'AssetsTypeModel',
        'depot_id'      => 'DepotModel'
    ];
    protected $sumableFields = ['cost', 'usedamt', 'stockamt'];
    
    protected $statFields = [
        'cost'    => 'cost'
    ];
    
    protected $exportFields = [
        'New Stock'         => ['field' => 'newstock', 'type' => 'bool'],
        'Type'              => ['field' => 'type_id', 'type' => 'foreign', 'table' => 'asset_types', 'tablefield' => 'name'],
        'Name'              => ['field' => 'name', 'type' => 'string'],
        'Amount'            => ['field' => 'amount', 'type' => 'decimal'],
        'Rate'              => ['field' => 'rate', 'type' => 'decimal'],
        'Cost'              => ['field' => 'cost', 'type' => 'decimal'],
        'Amount Used'       => ['field' => 'usedamt', 'type' => 'decimal'],
        'Amount Stock'      => ['field' => 'stockamt', 'type' => 'decimal'],
        'Depot'             => ['field' => 'depot_id', 'type' => 'foreign', 'table' => 'depot', 'tablefield' => 'name'],
        'Other Details'     => ['field' => 'details', 'type' => 'string'],
        'Description'       => ['field' => 'desc', 'type' => 'string'],
        'Date'              => ['field' => 'date', 'type' => 'date']
    ];
    
    protected function baseQueryBuilder() 
    {
        $selsql = "id, newstock, (". $this->toJsonQuery('AssetsTypeModel', 'assets_record.type_id') .") as `type`,"
                . "`name`,amount,rate,cost,usedamt,stockamt,(". $this->toJsonQuery('DepotModel', 'assets_record.depot_id') .") as depot,"
                . "details,desc,`date`";
        return $this->builder()->select($selsql);
    }
}
