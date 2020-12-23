<?php namespace App\Models;

use App\ExtendedModel;

/**
 * Description of CoalProcessedRecord
 *
 * @author rajnish
 */
class CoalProcessedRecordModel extends ExtendedModel
{
    protected $table = 'coal_processed_record';
    protected $primaryKey = 'id';
    
    protected $returnType = 'array';
    protected $availableFields = ['depotin_id', 'depotout_id', 'amount_in', 'amount_out', 'expenses',
        '(JSON_ARRSUM(JSON_EXTRACT(expenses, \'$.*\'))) AS expensesum' ,'date'];
    protected $allowedFields = ['depotin_id', 'depotout_id', 'amount_in', 'amount_out', 'expenses', 'date'];
    protected $useTimestamps = true;
    protected $useSoftDeletes = false;

    protected $validationRules    = [
        'depotin_id'    => 'required|greater_than[0]|numeric',
        'depotout_id'   => 'required|greater_than[0]|numeric',
        'amount_in'     => 'required|decimal',
        'amount_out'    => 'required|decimal',
        'expenses'      => 'required|valid_json',
        'date'          => 'required|valid_date'
    ];
    protected $validationMessages = [
        'depotin_id' => [
            'required'     => "Incoming depot is required!",
            'greater_than' => 'Invalid incoming Depot selected!'
        ],
        'depotout_id' => [
            'required'     => "Outgoing depot is required!",
            'greater_than' => 'Invalid outgoing Depot selected!'
        ],
        'amount_in' => [
            'required'  => 'The amount of raw coal fed for processing is required!',
            'decimal'   => 'Illegal characters in raw coal amount!'
        ],
        'amount_out' => [
            'required'  => 'The amount of product coal produced after processing is required!',
            'decimal'   => 'Illegal characters in cooked coal amount!'
        ],
        'expenses' => [
            'required'      => 'The expenses during the processing of coal is required!'
        ]
    ];
    protected $skipValidation     = false;
    
    protected $searchJsonFields     = ['depotin.name','depotin.incharge','depotin.city', 'depotin.state','depotin.area_pin',
        'depotout.name','depotout.incharge','depotout.city', 'depotout.state', 'depotout.area_pin'];
    protected $searchTableFields    = ['expenses'];
    protected $filterDFields        = ['depotin_id', 'depotout_id'];
    protected $filterNFields        = ['amount_in', 'amount_out', 'expensesum'];
    protected $orderJsonFields = ['depotin.name', 'depotout.name'];
    protected $orderTableFields = ['amount_in', 'amount_out', 'expensesum', 'date'];
    protected $editableFields = [
        'depotin_id'    => 'int',
        'depotout_id'   => 'int',
        'amount_in'     => 'decimal',
        'amount_out'    => 'decimal',
        'expenses'      => 'json',
        'date'          => 'date'
    ];
    protected $foreignFields = [
        'depotin_id'      => 'DepotModel',
        'depotout_id'     => 'DepotModel'
    ];
    protected $sumableFields = ['amount_in', 'amount_out', 'expensesum'];
    
    protected $statFields = [
        'amount_in'     => 'amount_in',
        'amount_out'    => 'amount_out',
        'expenses'      => "(JSON_ARRSUM(JSON_EXTRACT(expenses, '$.*')))"
    ];
    
    protected $exportFields = [
        'Depot IN'          => ['field' => 'depotin_id', 'type' => 'foreign', 'table' => 'depot', 'tablefield' => 'name'],
        'Depot OUT'         => ['field' => 'depotout_id', 'type' => 'foreign', 'table' => 'depot', 'tablefield' => 'name'],
        'Amount Raw'        => ['field' => 'amount_in', 'type' => 'decimal'],
        'Amount Product'    => ['field' => 'amount_out', 'type' => 'decimal'],
        'Rate'              => ['field' => 'rate', 'type' => 'decimal'],
        'Price'             => ['field' => 'price', 'type' => 'decimal'],
        'Expenses'          => ['field' => 'expensesum', 'type' => 'calc', 'calc' => "ROUND(JSON_ARRSUM(JSON_EXTRACT(expenses, '$.*')), 2)"],
        'Date'              => ['field' => 'date', 'type' => 'date']
    ];
    
    protected function baseQueryBuilder() {
        $selsql = "id, (". $this->toJsonQuery('DepotModel', 'coal_processed_record.depotin_id').") as depotin,"
                . "(". $this->toJsonQuery('DepotModel', 'coal_processed_record.depotout_id') .") as depotout,"
                . "amount_in,amount_out,expenses, (JSON_ARRSUM(JSON_EXTRACT(expenses, '$.*'))) AS expensesum,`date`";
        
        return $this->builder()->select($selsql);
    }
}
