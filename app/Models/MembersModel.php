<?php namespace App\Models;

use App\ExtendedModel;

/**
 * Description of MembersModel
 *
 * @author rajnish
 */
class MembersModel extends ExtendedModel
{
    protected $table = 'members';
    protected $primaryKey = 'id';
    
    protected $returnType = 'array';
    protected $availableFields = ['id', 'name', 'phone', 'email', 'address', 'city', 'state', 'country', 'pin', 'prof',
        'desg', 'corp'];
    protected $allowedFields = ['id', 'name', 'phone', 'email', 'address', 'city', 'state', 'country', 'pin', 'prof',
        'desg', 'corp'];
    protected $useTimestamps = true;
    protected $useSoftDeletes = true;

    protected $validationRules    = [
        'id'        => 'required|min_length[1]|max_length[100]|string',
        'name'      => 'required|min_length[1]|max_length[100]|string',
        'phone'     => 'required|min_length[1]|max_length[20]|string',
        'email'     => 'required|max_length[255]|valid_email',
        'address'   => 'required|max_length[255]|string',
        'city'      => 'required|max_length[100]|string',
        'state'     => 'required|max_length[100]|string',
        'country'   => 'required|max_length[100]|string',
        'pin'       => 'required|max_length[10]|alpha_numeric',
        'prof'      => 'required|min_length[1]|max_length[100]|string',
        'desg'      => 'required|min_length[1]|max_length[100]|string',
        'corp'      => 'required|min_length[1]|max_length[100]|string'
    ];
    protected $validationMessages = [
        
    ];
    protected $skipValidation       = false;
    
    protected $searchTableFields    = ['id', 'name', 'phone', 'email', 'address', 'city', 'state', 'country', 'pin', 'prof',
        'desg', 'corp'];
    protected $filterUFields        = ['id', 'name', 'phone', 'email', 'address', 'city', 'state', 'country', 'pin', 'prof',
        'desg', 'corp'];
    protected $orderTableFields     = ['id', 'name', 'phone', 'email', 'address', 'city', 'state', 'country', 'pin', 'prof',
        'desg', 'corp'];
    protected $topResultsFields     = ['name'];
    protected $editableFields = [
        'id'        => 'string',
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
        'corp'      => 'string'
    ];
    
    protected $exportFields = [
        'ID'            => ['field' => 'id', 'type' => 'string'],
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
        'Corporation'   => ['field' => 'corp', 'type' => 'string']
    ];
}
