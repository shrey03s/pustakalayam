<?php namespace App\Models;

use App\ExtendedModel;

/**
 * Description of VisitorsRecordModel
 *
 * @author rajnish
 */
class VisitorsRecordModel extends ExtendedModel
{
    protected $table = 'visitors_record';
    protected $primaryKey = 'id';
    
    protected $returnType = 'array';
    protected $availableFields =['mem_id', 'date', 'valid_until', 'charge', 'paid', 'remain'];
    protected $allowedFields = ['mem_id', 'date', 'valid_until', 'charge', 'paid'];
    protected $useTimestamps = true;
    protected $useSoftDeletes = false;

    protected $validationRules    = [
        'mem_id'        => 'required|greater_than[0]|numeric',
        'date'          => 'required|valid_date',
        'valid_until'   => 'required|valid_date',
        'charge'        => 'permit_empty|decimal',
        'paid'          => 'permit_empty|decimal'
    ];
    protected $validationMessages = [
    ];
    protected $skipValidation     = false;
    
    protected $searchJsonFields     = ['mem.id', 'mem.name', 'mem.phone', 'mem.email', 'mem.address', 'mem.city', 'mem.state', 'mem.country',
        'mem.pin', 'mem.prof', 'mem.desg', 'mem.corp'];
    protected $filterDFields        = ['mem_id'];
    protected $filterNFields        = ['date', 'valid_until', 'charge', 'paid'];
    protected $orderJsonFields      = ['mem.id'];
    protected $orderTableFields     = ['date', 'valid_until', 'charge', 'paid'];
    protected $editableFields = [
        'mem_id'    => 'int',
        'name'      => 'string',
        'phone'     => 'string',
        'email'     => 'string',
        'address'   => 'string',
        'city'      => 'string',
        'state'     => 'string',
        'country'   => 'string',
        'pin'       => 'string',
        'prof'      => 'string',
        'desg'      => 'string',
        'corp'      => 'string',
        'time_in'   => 'string',
        'time_out'  => 'string',
        'charge'    => 'decimal'
    ];
    protected $foreignFields = [
        'mem_id'    => 'MembersModel'
    ];
    protected $sumableFields = ['charge'];
        
    protected $exportFields = [
        'Name'          => ['field' => 'name', 'type' => 'string'],
        'Phone'         => ['field' => 'phone', 'type' => 'string'],
        'Email'         => ['field' => 'email', 'type' => 'string'],
        'Address'       => ['field' => 'address', 'type' => 'string'],
        'City'          => ['field' => 'city', 'type' => 'string'],
        'State'         => ['field' => 'state', 'type' => 'string'],
        'Country'       => ['field' => 'country', 'type' => 'string'],
        'Pin'           => ['field' => 'pin', 'type' => 'string'],
        'Profession'    => ['field' => 'prof', 'type' => 'string'],
        'Designation'   => ['field' => 'desg', 'type' => 'string'],
        'Corporation'   => ['field' => 'corp', 'type' => 'string'],
        'Time IN'       => ['field' => 'time_in', 'type' => 'string'],
        'Time OUT'      => ['field' => 'time_out', 'type' => 'string'],
        'Charge'        => ['field' => 'charge', 'type' => 'decimal']
    ];
}
