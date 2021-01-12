<?php namespace App\Models;

use App\ExtendedModel;

/**
 * Description of IssueRecordModel
 *
 * @author rajnish
 */
class IssueRecordModel extends ExtendedModel
{
    protected $table = 'issue_record';
    protected $primaryKey = 'id';
    
    protected $returnType = 'array';
    protected $availableFields =['renew_id', 'renewed', 'mem_id', 'book_id', 'fine_rate', 'date', 'eret_date', 'aret_date', 'addfine',
        'fine', 'paid', 'remain', 'is_paid'];
    protected $allowedFields = ['renew_id', 'mem_id', 'book_id', 'fine_rate', 'date', 'eret_date', 'aret_date', 'addfine', 'paid'];
    protected $useTimestamps = true;
    protected $useSoftDeletes = false;

    protected $validationRules    = [
        'renew_id'      => 'permit_empty|numeric',
        'mem_id'        => 'required|numeric',
        'book_id'       => 'required|numeric',
        'date'          => 'required|valid_date',
        'eret_date'     => 'required|valid_date',
        'aret_date'     => 'permit_empty|valid_date',
        'addfine'       => 'permit_empty|decimal',
        'paid'          => 'permit_empty|decimal'
    ];
    protected $validationMessages = [
    ];
    protected $skipValidation     = false;
    
    protected $searchJsonFields     = ['mem.name', 'mem.uid', 'mem.phone', 'mem.email', 'mem.address', 'mem.city', 'mem.state', 'mem.country',
        'mem.pin', 'mem.prof', 'mem.desg', 'mem.corp', 'book.name', 'book.author', 'book.genre', 'book.category', 'book.isbn', 'book.publ',
        'book.desc', 'book.sec'];
    protected $searchBooleanFields  = ['is_paid', 'renewed'];
    protected $filterDFields        = ['mem_id', 'book_id', 'is_paid', 'renewed'];
    protected $filterNFields        = ['fine_rate', 'date', 'eret_date', 'aret_date', 'addfine', 'fine', 'paid', 'remain'];
    protected $orderJsonFields      = ['mem.uid', 'book.name'];
    protected $orderTableFields     = ['date', 'renewed', 'fine', 'paid', 'remain', 'is_paid'];
    protected $editableFields = [
        'renew_id'      => 'int',
        'mem_id'        => 'int',
        'book_id'       => 'numeric',
        'date'          => 'date',
        'eret_date'     => 'valid_date',
        'aret_date'     => 'date',
        'addfine'       => 'decimal',
        'paid'          => 'decimal'
    ];
    protected $foreignFields = [
        'mem_id'    => 'MembersModel',
        'book_id'   => 'BooksModel'
    ];
    protected $sumableFields = ['paid'];
    
    protected $exportFields = [
        'MID'                       => ['field' => 'mem_id', 'type' => 'foreign', 'table' => 'members', 'tablefield' => 'uid'],
        'Book'                      => ['field' => 'book_id', 'type' => 'foreign', 'table' => 'books', 'tablefield' => 'name'],
        'Date'                      => ['field' => 'valid_until', 'type' => 'date'],
        'Expected Return Date'      => ['field' => 'eret_date', 'type' => 'date'],
        'Actual Return Date'        => ['field' => 'eret_date', 'type' => 'date'],
        'Additional Deductions'     => ['field' => 'addfine', 'type' => 'decimal'],
        'Fine'                      => ['field' => 'fine', 'type' => 'decimal'],
        'Paid'                      => ['field' => 'paid', 'type' => 'decimal']
    ];
}
