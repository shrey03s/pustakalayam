<?php namespace App\Models;

use App\ExtendedModel;

/**
 * Description of MembershipRecordModel
 *
 * @author rajnish
 */
class MembershipRecordModel extends ExtendedModel
{
    protected $table = 'mem_record';
    protected $primaryKey = 'id';
    
    protected $returnType = 'array';
    protected $availableFields = ['mem_id', 'date', 'valid_until', 'charge', 'paid', 'remain', 'is_paid'];
    protected $allowedFields = ['mem_id', 'date', 'valid_until', 'charge', 'paid'];
    protected $useTimestamps = true;
    protected $useSoftDeletes = false;

    protected $validationRules    = [
        'mem_id'        => 'required|min_length[1]|max_length[100]|string',
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
    protected $searchBooleanFields  = ['is_paid'];
    protected $filterDFields        = ['mem_id', 'is_paid'];
    protected $filterNFields        = ['date', 'valid_until', 'charge', 'paid', 'remain'];
    protected $orderJsonFields      = ['mem.id'];
    protected $orderTableFields     = ['date', 'valid_until', 'charge', 'paid', 'remain', 'is_paid'];
    protected $editableFields = [
        'mem_id'        => 'string',
        'date'          => 'date',
        'valid_until'   => 'date',
        'charge'        => 'decimal',
        'paid'          => 'decimal'
    ];
    protected $foreignFields = [
        'mem_id'    => 'MembersModel'
    ];
    protected $sumableFields = ['charge', 'paid'];
        
    protected $exportFields = [
        'MID'           => ['field' => 'mem_id', 'type' => 'string'],
        'Date'          => ['field' => 'date', 'type' => 'date'],
        'Valid Util'    => ['field' => 'valid_until', 'type' => 'date'],
        'Charge'        => ['field' => 'charge', 'type' => 'decimal'],
        'Paid'          => ['field' => 'paid', 'type' => 'decimal']
    ];
}
