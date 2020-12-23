<?php namespace App\Models;

use App\ExtendedModel;

/**
 * Description of CoalSoldRecord
 *
 * @author rajnish
 */
class CoalSoldRecordModel extends ExtendedModel
{
    protected $table = 'coal_sold_record';
    protected $primaryKey = 'id';
    
    protected $returnType = 'array';
    protected $availableFields = ['buyer_id', 'depot_id', 'amount', 'rate', 'price', 'is_processed', 'date'];
    protected $allowedFields = ['buyer_id', 'depot_id', 'amount', 'rate', 'is_processed', 'date'];
    protected $useTimestamps = true;
    protected $useSoftDeletes = false;

    protected $validationRules    = [
        'buyer_id'      => 'required|greater_than[0]|numeric',
        'depot_id'      => 'required|greater_than[0]|numeric',
        'amount'        => 'required|decimal',
        'rate'          => 'required|decimal',
        'is_processed'  => 'required|bool',
        'date'          => 'required|valid_date'
    ];
    protected $validationMessages = [
        'buyer_id' => [
            'required'     => "Coal Customer is required!",
            'greater_than' => 'Invalid Coal Customer selected!'
        ],
        'depot_id' => [
            'greater_than' => 'Invalid Depot selected!'
        ],
        'amount' => [
            'required'  => 'The amount of coal sold is required!',
            'decimal'   => 'Illegal characters in `amount`!'
        ],
        'rate' => [
            'required'  => 'The rate of price of coal sold is required!',
            'decimal'   => 'Illegal characters in `rate`!'
        ],
        'is_processed' => [
            'required'      => "It's required to state if the coal sold, was processed!",
            'bool'          => "Invalid value for value of coal proccessed or raw!"
        ]
    ];
    protected $skipValidation     = false;
    
    protected $searchJsonFields     = ['buyer.name', 'buyer.address', 'buyer.city', 'buyer.state', 'buyer.country',
        'buyer.area_pin', 'buyer.phone', 'buyer.email', 'buyer.gstin',  'buyer.details', 'depot.name','depot.incharge',
        'depot.city', 'depot.state', 'depot.area_pin'];
    protected $searchBooleanFields  = ['is_processed'];
    protected $filterDFields        = ['buyer_id','depot_id'];
    protected $filterNFields        = ['is_processed', 'amount', 'rate', 'price'];
    protected $orderJsonFields      = ['buyer.name', 'depot.name'];
    protected $orderTableFields     = ['amount', 'rate', 'price', 'is_processed', 'date'];
    protected $editableFields = [
        'amount'        => 'decimal',
        'buyer_id'      => 'int',
        'depot_id'      => 'int',
        'rate'          => 'decimal',
        'is_processed'  => 'bool',
        'date'          => 'date'
    ];
    protected $foreignFields = [
        'buyer_id'      => 'CoalCustomersModel',
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
        'Customer'  => ['field' => 'supplier_id', 'type' => 'foreign', 'table' => 'coal_customers', 'tablefield' => 'name'],
        'Depot'     => ['field' => 'depot_id', 'type' => 'foreign', 'table' => 'depot', 'tablefield' => 'name'],
        'Amount'    => ['field' => 'amount', 'type' => 'decimal'],
        'Rate'      => ['field' => 'rate', 'type' => 'decimal'],
        'Price'     => ['field' => 'price', 'type' => 'decimal'],
        'Processed' => ['field' => 'is_processed', 'type' => 'bool'],
        'Date'      => ['field' => 'date', 'type' => 'date']
    ];
    
    protected function baseQueryBuilder() {
        $selsql = "id, (". $this->toJsonQuery('CoalCustomersModel', 'coal_sold_record.buyer_id').") as buyer,"
                . "(". $this->toJsonQuery('DepotModel', 'coal_sold_record.depot_id') .") as depot,"
                . "amount,rate,price,is_processed,`date`";
        
        return $this->builder()->select($selsql);
    }
}
