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
    protected $availableFields =['mem_id', 'book_id','name', 'phone', 'email', 'address', 'city', 'state', 'country', 
        'pin', 'prof', 'desg', 'corp', 'time_in', 'time_out',  'charge'];
    protected $allowedFields = ['mem_id', 'book_id', 'name', 'phone', 'email', 'address', 'city', 'state', 'country', 
        'pin', 'prof', 'desg', 'corp', 'time_in', 'time_out', 'charge'];
    protected $useTimestamps = true;
    protected $useSoftDeletes = false;

    protected $validationRules    = [
        'mem_id'    => 'required|numeric',
        'book_id'   => 'required|numeric',
        'name'      => 'required|min_length[1]|max_length[100]|string',
        'phone'     => 'required|min_length[1]|max_length[20]|string',
        'email'     => 'required|max_length[255]|valid_email',
        'address'   => 'permit_empty|max_length[255]|string',
        'city'      => 'permit_empty|max_length[100]|string',
        'state'     => 'permit_empty|max_length[100]|string',
        'country'   => 'permit_empty|max_length[100]|string',
        'pin'       => 'permit_empty|max_length[10]|alpha_numeric',
        'prof'      => 'required|min_length[1]|max_length[100]|string',
        'desg'      => 'required|min_length[1]|max_length[100]|string',
        'corp'      => 'required|min_length[1]|max_length[100]|string',
        'time_in'   => 'required|string',
        'time_out'  => 'permit_empty|string',
        'charge'    => 'permit_empty|decimal'
    ];
    protected $validationMessages = [
    ];
    protected $skipValidation     = false;
    
    protected $searchJsonFields     = ['mem.id', 'mem.name', 'mem.phone', 'mem.email', 'mem.address', 'mem.city', 'mem.state', 'mem.country',
        'mem.pin', 'mem.prof', 'mem.desg', 'mem.corp', 'book.name', 'book.edition', 'book.author', 'book.genre', 
        'book.category', 'book.isbn', 'book.publ', 'book.desc', 'book.sec'];
    protected $searchTableFields    = ['name', 'phone', 'email', 'address', 'city', 'state', 'country', 'pin', 'prof',
        'desg', 'corp'];
    protected $filterDFields        = ['mem_id', 'book_id'];
    protected $filterNFields        = ['time_in', 'time_out', 'charge'];
    protected $filterUFields        = ['name', 'phone', 'email', 'address', 'city', 'state', 'country', 'pin', 'prof',
        'desg', 'corp'];
    protected $orderJsonFields      = ['mem.uid', 'book.name'];
    protected $orderTableFields     = ['name', 'phone', 'email', 'address', 'city', 'state', 'country', 'pin', 'prof',
        'desg', 'corp', 'time_in', 'time_out',  'charge'];
    protected $editableFields = [
        'mem_id'    => 'int',
        'book_id'   => 'int',
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
        'mem_id'    => 'MembersModel',
        'book_id'   => 'BooksModel'
    ];
    protected $sumableFields = ['charge'];
        
    protected $exportFields = [
        'MID'           => ['field' => 'mem_id', 'type' => 'foreign', 'table' => 'members', 'tablefield' => 'uid'],
        'Book'          => ['field' => 'book_id', 'type' => 'foreign', 'table' => 'books', 'tablefield' => 'name'],
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
