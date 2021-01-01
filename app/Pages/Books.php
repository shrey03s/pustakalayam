<?php namespace App\Pages;

/**
 * Description of Books
 *
 * @author rajnish
 */
class Books 
{
    public $tabletitle = "Books Manager";
    public $pageclass = "books";
    public $pagesection = "books";
    public $model = 'books';
    public $order = 'ASC';
    public $getentries = "/api/entries";
    public $putentry = "/api/putentry";
    public $entrycount = '/api/entriesinfo';
    public $deleteentry = '/api/delete';
    
    public $tablefields = [
        'Cover'          => ['cover' => 'img'],
        'Name'           => ['name' => 'text'],
        'Edition'        => ['edition' => 'text'],
        'Author'         => ['author' => 'text'],
        'Publication'    => ['publ' => 'text'],
        'ISBN'           => ['isbn' => 'text'],
        'Genre'          => ['genre' => 'text'],
        'Category'       => ['category' => 'text'],
        'Price'          => ['price' => 'text'],
        'Purchase Date'  => ['date' => 'date']
    ];
    public $orderfields = [
        'Name'           => ['field' => 'name'],
        'Edition'        => ['field' => 'edition'],
        'Author'         => ['field' => 'author'],
        'Publication'    => ['field' => 'publ'],
        'ISBN'           => ['field' => 'isbn'],
        'Genre'          => ['field' => 'genre'],
        'Category'       => ['field' => 'category'],
        'Price'          => ['field' => 'price'],
        'Date'           => ['field' => 'date', 'selected' => true],
    ];
    public $searchfields = [
        'Name'           => 'name',
        'Edition'        => 'edition',
        'Author'         => 'author',
        'Publication'    => 'publ',
        'ISBN'           => 'isbn',
        'Genre'          => 'genre',
        'Category'       => 'category',
        'Description'    => 'desc',
        'Section'        => 'sec'
    ];
    public $modals = [
        'create'    => [
            'title' => 'Add Book',
            'action_button' => 'Add',
            'close_button'  => 'Cancel',
            'elms'  => [
                [
                    'type'  => 'text',
                    'name'  => 'name',
                    'label' => 'Name',
                    'required'  => true
                ],
                [
                    'type'  => 'file',
                    'name'  => 'type',
                    'label' => 'Cover',
                    'required'  => true
                ],
                [
                    'type'  => 'date',
                    'name'  => 'date',
                    'label' => 'Date of Purchase'
                ]
            ]
        ],
        'edit'      => [
            'title' => 'Edit Book',
            'action_button' => 'Edit',
            'close_button'  => 'Cancel',
            'elms'  => [
                [
                    'type'  => 'text',
                    'name'  => 'vin',
                    'label' => 'Vehicle ID Number (VIN)',
                    'required'  => true,
                    'fill'  => 'vin'
                ],
                [
                    'type'  => 'text',
                    'name'  => 'type',
                    'label' => 'Vehicle Type',
                    'required'  => true,
                    'fill'  => 'type'
                ],
                [
                    'type'  => 'date',
                    'name'  => 'date',
                    'label' => 'Date of Purchase',
                    'fill'  => 'date'
                ]
            ]
        ],
        'filter' => [
            'title' => 'Filter Vehicles',
            'action_button' => 'Filter',
            'close_button' => 'Cancel',
            'elms' => [
                [
                    'type'  => 'text',
                    'name'  => 'vin',
                    'label' => 'Vehicle ID Number (VIN)'
                ],
                [
                    'type'  => 'text',
                    'name'  => 'type',
                    'label' => 'Vehicle Type'
                ]
            ]
        ],
        'details' => [
            'title' => 'Book Details',
            'action_button' => null,
            'close_button'  => 'Close',
            'elms'  => [
                'Cover'             => ['field' => 'cover', 'type' => 'img'],
                'Name'              => ['field' => 'name', 'type' => 'text'],
                'Author'            => ['field' => 'author', 'type' => 'text'],
                'Edition'           => ['field' => 'edition', 'type' => 'text'],
                'Publication'       => ['field' => 'publ', 'type' => 'text'],
                'ISBN'              => ['field' => 'isbn', 'type' => 'text'],
                'Genre'             => ['field' => 'genre', 'type' => 'text'],
                'Category'          => ['field' => 'category', 'type' => 'text'],
                'Price'             => ['field' => 'price', 'type' => 'decimal'],
                'Date of Purchase'  => ['field' => 'date', 'type' => 'date'],
                'Section'           => ['field' => 'sec', 'type' => 'text'],
                'Shelf'             => ['field' => 'shelf', 'type' => 'number'],
                'Row'               => ['field' => 'row', 'type' => 'number'],
                'Description'       => ['field' => 'desc', 'type' => 'text']
            ]
        ],
        'delete'    => [
            'title' => 'Delete Book',
            'action_button' => 'Delete',
            'close_button'  => 'Cancel',
            'elms'  => [
                [
                    'type'  => 'label',
                    'value' => 'Do you really want to delete the Book ?',
                ]
            ]
        ]
    ];
}
