<?php namespace App\Models;

use App\ExtendedModel;

/**
 * Description of MiningRecord
 *
 * @author rajnish
 */
class MiningRecordModel extends ExtendedModel
{
    protected $table = 'mining_record';
    protected $primaryKey = 'id';
    
    protected $returnType = 'array';
    protected $availableFields = ['vehicle_id', 'mine_id', 'depot_id', 'amount', 'rate', 'price', 'expenses', 
        '(JSON_ARRSUM(JSON_EXTRACT(expenses, \'$.*\'))) AS expensesum', 
        '(`price`-(JSON_ARRSUM(JSON_EXTRACT(expenses, \'$.*\')))) AS gross','date'];
    protected $allowedFields = ['vehicle_id', 'mine_id', 'depot_id', 'amount', 'rate', 'expenses', 'date'];
    protected $useTimestamps = true;
    protected $useSoftDeletes = false;

    protected $validationRules    = [
        'vehicle_id'    => 'required|greater_than[0]|numeric',
        'mine_id'       => 'required|greater_than[0]|numeric',
        'depot_id'      => 'required|greater_than[0]|numeric',
        'amount'        => 'required|decimal',
        'rate'          => 'required|decimal',
        'expenses'      => 'required|valid_json',
        'date'          => 'required|valid_date'
    ];
    protected $validationMessages = [
        'vehicle_id' => [
            'greater_than' => 'Invalid Vehicle selected!'
        ],
        'mine_id' => [
            'greater_than' => 'Invalid Mine selected!'
        ],
        'depot_id' => [
            'greater_than' => 'Invalid Depot selected!'
        ],
        'amount' => [
            'required'  => 'The amount of coal trasported after mining is required!',
            'decimal'   => 'Illegal characters in `amount`!'
        ],
        'rate' => [
            'required'  => 'The rate of price of coal trasported after mining is required!',
            'decimal'   => 'Illegal characters in `rate`!'
        ],
        'expenses' => [
            'required'      => 'The expenses during the transportation mined coal is required!'
        ]
    ];
    protected $skipValidation     = false;
    
    protected $searchJsonFields     = ['vehicle.vin', 'vehicle.type', 'mine.name', 'mine.city', 'mine.state','mine.area_pin', 'depot.name','depot.incharge',
        'depot.city', 'depot.state', 'depot.area_pin'];
    protected $searchTableFields    = ['expenses'];
    protected $filterDFields        = ['vehicle_id', 'mine_id', 'depot_id'];
    protected $filterNFields        = ['amount', 'rate', 'price', 'expensesum', 'gross'];
    protected $orderJsonFields      = ['vehicle.vin', 'mine.name', 'depot.name'];
    protected $orderTableFields     = ['amount', 'rate','price', 'expensesum', 'gross','date'];
    protected $editableFields = [
        'vehicle_id'    => 'int',
        'mine_id'       => 'int',
        'depot_id'      => 'int',
        'amount'        => 'decimal',
        'rate'          => 'decimal',
        'expenses'      => 'json',
        'date'          => 'date'
    ];
    protected $foreignFields = [
        'vehicle_id'    => 'VehiclesModel',
        'mine_id'       => 'MineModel',
        'depot_id'      => 'DepotModel'
    ];
    protected $sumableFields = ['amount', 'price', 'expensesum', 'gross'];
    
    protected $statFields = [
        'amount'    => 'amount',
        'price'     => 'price',
        'expenses'  => "(JSON_ARRSUM(JSON_EXTRACT(expenses, '$.*')))",
        'gross'     => "(`price`-(JSON_ARRSUM(JSON_EXTRACT(expenses, '$.*'))))"
    ];
    
    protected $exportFields = [
        'Vehicle'   => ['field' => 'vehicle_id', 'type' => 'foreign', 'table' => 'vehicles', 'tablefield' => 'vin'],
        'Mine'      => ['field' => 'mine_id', 'type' => 'foreign', 'table' => 'mine', 'tablefield' => 'name'],
        'Depot'     => ['field' => 'depot_id', 'type' => 'foreign', 'table' => 'depot', 'tablefield' => 'name'],
        'Amount'    => ['field' => 'amount', 'type' => 'decimal'],
        'Rate'      => ['field' => 'rate', 'type' => 'decimal'],
        'Price'     => ['field' => 'price', 'type' => 'decimal'],
        'Expenses'  => ['field' => 'expensesum', 'type' => 'calc', 'calc' => "ROUND(JSON_ARRSUM(JSON_EXTRACT(expenses, '$.*')), 2)"],
        'Gross'     => ['field' => 'gross', 'type' => 'calc', 'calc' => "ROUND(`price`-(JSON_ARRSUM(JSON_EXTRACT(expenses, '$.*'))), 2)"],
        'Date'      => ['field' => 'date', 'type' => 'date']
    ];

    protected function baseQueryBuilder() {
        $selsql = "id, (". $this->toJsonQuery('VehiclesModel', 'mining_record.vehicle_id') .") as vehicle,"
                . "(". $this->toJsonQuery('MineModel', 'mining_record.mine_id') .") as mine,"
                . "(". $this->toJsonQuery('DepotModel', 'mining_record.depot_id') .") as depot,"
                . "amount, rate, price, expenses, (JSON_ARRSUM(JSON_EXTRACT(expenses, '$.*'))) AS expensesum,"
                . "(`price`-(JSON_ARRSUM(JSON_EXTRACT(expenses, '$.*')))) AS gross, `date`";
        
        return $this->builder()->select($selsql);
    }
}
