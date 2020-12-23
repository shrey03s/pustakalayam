<?php namespace App\Models;

use App\ExtendedModel;

/**
 * Description of CoalSoldRecord
 *
 * @author rajnish
 */
class CoalPurchasedRecordModel extends ExtendedModel
{
    protected $table = 'coal_purchased_record';
    protected $primaryKey = 'id';
    
    protected $returnType = 'array';
    protected $availableFields = ['supplier_id', 'depot_id', 'amount', 'rate', 'price', 'is_processed', 'date'];
    protected $allowedFields = ['supplier_id', 'depot_id', 'amount', 'rate', 'is_processed', 'date'];
    protected $useTimestamps = true;
    protected $useSoftDeletes = false;

    protected $validationRules    = [
        'supplier_id'   => 'required|greater_than[0]|numeric',
        'depot_id'      => 'required|greater_than[0]|numeric',
        'amount'        => 'required|decimal',
        'rate'          => 'required|decimal',
        'is_processed'  => 'required|bool',
        'date'          => 'required|valid_date'
    ];
    protected $validationMessages = [
        'supplier_id' => [
            'required'     => "Coal Supplier is required!",
            'greater_than' => 'Invalid Coal Supplier selected!'
        ],
        'depot_id' => [
            'required'     => "Depot is required!",
            'greater_than' => 'Invalid Depot selected!'
        ],
        'amount' => [
            'required'  => 'The amount of coal purchased is required!',
            'decimal'   => 'Illegal characters in `amount`!'
        ],
        'rate' => [
            'required'  => 'The rate of price of purchased coal is required!',
            'decimal'   => 'Illegal characters in `rate`!'
        ],
        'is_processed' => [
            'required'      => "It's required to state if the coal purchased, was processed!",
            'bool'          => "Invalid value for value of coal processed or raw!"
        ]
    ];
    protected $skipValidation     = false;
    
    protected $searchJsonFields     = ['supplier.name', 'supplier.address', 'supplier.city', 'supplier.state', 'supplier.country',
        'supplier.area_pin', 'supplier.phone', 'supplier.email', 'supplier.gstin',  'supplier.details',
        'depot.name','depot.incharge','depot.city', 'depot.state', 'depot.area_pin'];
    protected $searchBooleanFields  = ['is_processed'];
    protected $filterDFields        = ['supplier_id', 'depot_id'];
    protected $filterNFields        = ['is_processed', 'amount', 'rate', 'price'];
    protected $orderJsonFields      = ['supplier.name', 'depot.name'];
    protected $orderTableFields     = ['amount', 'rate', 'price', 'is_processed', 'date'];
    protected $editableFields = [
        'supplier_id'   => 'int',
        'depot_id'      => 'int',
        'amount'        => 'decimal',
        'rate'          => 'decimal',
        'is_processed'  => 'bool',
        'date'          => 'date'
    ];
    protected $foreignFields = [
        'supplier_id'   => 'CoalSuppliersModel',
        'depot_id'      => 'DepotModel'
    ];
    protected $sumableFields = ['amount', 'price'];
    
    protected $statFields = [
        'rawamt'    => "IF(`is_processed`, 0,`amount`)",
        'cookamt'   => "IF(`is_processed`,`amount`,0)",
        'rawprice'  => "IF(`is_processed`, 0,`price`)",
        'cookprice' => "IF(`is_processed`,`price`,0)",
        'price'     => 'price'
    ];
    
    protected $exportFields = [
        'Supplier'  => ['field' => 'supplier_id', 'type' => 'foreign', 'table' => 'coal_suppliers', 'tablefield' => 'name'],
        'Depot'     => ['field' => 'depot_id', 'type' => 'foreign', 'table' => 'depot', 'tablefield' => 'name'],
        'Amount'    => ['field' => 'amount', 'type' => 'decimal'],
        'Rate'      => ['field' => 'rate', 'type' => 'decimal'],
        'Price'     => ['field' => 'price', 'type' => 'decimal'],
        'Processed' => ['field' => 'is_processed', 'type' => 'bool'],
        'Date'      => ['field' => 'date', 'type' => 'date']
    ];
    
    protected function baseQueryBuilder() {
        $selsql = "id, (". $this->toJsonQuery('CoalSuppliersModel', 'coal_purchased_record.supplier_id').") as supplier,"
                . "(". $this->toJsonQuery('DepotModel', 'coal_purchased_record.depot_id') .") as depot,"
                . "amount,rate,price,is_processed,`date`";
        
        return $this->builder()->select($selsql);
    }
}
