<?php namespace App\Models;

use App\ExtendedModel;

/**
 * Description of BooksModel
 *
 * @author rajnish
 */
class BooksModel extends ExtendedModel
{
    protected $table = 'books';
    protected $primaryKey = 'id';
    
    protected $returnType = 'array';
    protected $availableFields = ['name', 'img', 'author', 'genre', 'category', 'edition', 'isbn', 'publ', 'desc', 'price',
        'charge', 'date', 'amt', 'sec', 'shelf', 'row'];
    protected $allowedFields = ['name', 'img', 'author', 'genre', 'category', 'edition', 'isbn', 'publ', 'desc', 'price',
        'charge', 'date', 'amt', 'sec', 'shelf', 'row'];
    protected $useTimestamps = true;
    protected $useSoftDeletes = true;

    protected $validationRules    = [
        'name'      => 'required|min_length[1]|max_length[255]|string',
        'img'       => 'permit_empty|string',
        'author'    => 'required|min_length[1]|max_length[100]|string',
        'genre'     => 'required|min_length[1]|max_length[100]|string',
        'category'  => 'required|min_length[1]|max_length[100]|string',
        'edition'   => 'permit_empty|max_length[10]|alpha_numeric',
        'isbn'      => 'permit_empty|max_length[20]|alpha_numeric_punct',
        'publ'      => 'permit_empty|min_length[1]|max_length[100]|string',
        'desc'      => 'permit_empty|string',
        'price'     => 'required|decimal',
        'charge'    => 'required|decimal',
        'date'      => 'required|valid_date',
        'amt'       => 'required|numeric',
        'sec'       => 'required|min_length[1]|max_length[100]|string',
        'shelf'     => 'required|numeric',
        'row'       => 'required|numeric'
    ];
    protected $validationMessages = [
        
    ];
    protected $skipValidation       = false;
    
    protected $searchTableFields    = ['name', 'author', 'genre', 'category', 'isbn', 'publ', 'desc', 'sec'];
    protected $filterUFields        = ['name', 'author', 'genre', 'category', 'isbn', 'publ', 'desc', 'sec'];
    protected $filterNFields        = ['price', 'charge'];
    protected $orderTableFields     = ['name', 'author', 'genre', 'category', 'isbn', 'publ', 'sec'];
    protected $topResultsFields     = ['name', 'author', 'genre', 'category', 'isbn', 'publ', 'sec'];
    protected $editableFields = [
        'name'      => 'string',
        'img'       => 'string',
        'author'    => 'string',
        'genre'     => 'string',
        'category'  => 'string',
        'edition'   => 'int',
        'isbn'      => 'string',
        'publ'      => 'string',
        'desc'      => 'string',
        'price'     => 'decimal',
        'charge'    => 'decimal',
        'date'      => 'date',
        'amt'       => 'int',
        'sec'       => 'string',
        'shelf'     => 'int',
        'row'       => 'int'
    ];
    
    protected $exportFields = [
        'Name'          => ['field' => 'name', 'type' => 'string'],
        'Author'        => ['field' => 'author', 'type' => 'string'],
        'Genre'         => ['field' => 'genre', 'type' => 'string'],
        'Category'      => ['field' => 'category', 'type' => 'string'],
        'Edition'       => ['field' => 'edition', 'type' => 'string'],
        'ISBN'          => ['field' => 'isbn', 'type' => 'string'],
        'Publication'   => ['field' => 'publ', 'type' => 'string'],
        'Description'   => ['field' => 'desc', 'type' => 'string'],
        'Price'         => ['field' => 'price', 'type' => 'decimal'],
        'Date'          => ['field' => 'date', 'type' => 'date'],
        'Copies'        => ['field' => 'amt', 'type' => 'int'],
        'Section'       => ['field' => 'sec', 'type' => 'string'],
        'Shelf'         => ['field' => 'shelf', 'type' => 'int'],
        'Row'           => ['field' => 'row', 'type' => 'int']
    ];
}
