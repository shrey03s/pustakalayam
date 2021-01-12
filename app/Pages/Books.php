<?php namespace App\Pages;

/**
 * Description of Books
 *
 * @author rajnish
 */
class Books 
{
    public $tabletitle = "Books";
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
                    'name'  => 'cover',
                    'label' => 'Cover'
                ],
                [
                    'type'  => 'text',
                    'name'  => 'author',
                    'label' => 'Author',
                    'required'  => true
                ],
                [
                    'type'  => 'text',
                    'name'  => 'genre',
                    'label' => 'Genre',
                    'required'  => true
                ],
                [
                    'type'  => 'text',
                    'name'  => 'category',
                    'label' => 'Category',
                    'required'  => true
                ],
                [
                    'type'  => 'text',
                    'name'  => 'edition',
                    'label' => 'Edition'
                ],
                [
                    'type'  => 'text',
                    'name'  => 'isbn',
                    'label' => 'ISBN'
                ],
                [
                    'type'  => 'text',
                    'name'  => 'publ',
                    'label' => 'Publication'
                ],
                [
                    'type'  => 'text',
                    'name'  => 'desc',
                    'label' => 'Description'
                ],
                [
                    'type'  => 'number',
                    'name'  => 'price',
                    'label' => 'Price',
                    'value' => 0.0
                ],
                [
                    'type'  => 'date',
                    'name'  => 'date',
                    'label' => 'Date of Purchase'
                ],
                [
                    'type'  => 'number',
                    'name'  => 'amt',
                    'label' => 'No of Copies',
                    'value' => 1,
                    'required' => true
                ],
                [
                    'type'  => 'text',
                    'name'  => 'sec',
                    'label' => 'Section',
                    'required' => true
                ],
                [
                    'type'  => 'number',
                    'name'  => 'shelf',
                    'label' => 'shelf',
                    'required' => true
                ],
                [
                    'type'  => 'number',
                    'name'  => 'row',
                    'label' => 'Row',
                    'required' => true
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
                    'name'  => 'name',
                    'label' => 'Name',
                    'required'  => true,
                    'fill'  => 'name'
                ],
                [
                    'type'  => 'file',
                    'name'  => 'cover',
                    'label' => 'Cover'
                ],
                [
                    'type'  => 'text',
                    'name'  => 'author',
                    'label' => 'Author',
                    'required'  => true,
                    'fill'  => 'author'
                ],
                [
                    'type'  => 'text',
                    'name'  => 'genre',
                    'label' => 'Genre',
                    'required'  => true,
                    'fill'  => 'genre'
                ],
                [
                    'type'  => 'text',
                    'name'  => 'category',
                    'label' => 'Category',
                    'required'  => true,
                    'fill'  => 'category'
                ],
                [
                    'type'  => 'text',
                    'name'  => 'edition',
                    'label' => 'Edition',
                    'fill'  => 'edition'
                ],
                [
                    'type'  => 'text',
                    'name'  => 'isbn',
                    'label' => 'ISBN',
                    'fill'  => 'isbn'
                ],
                [
                    'type'  => 'text',
                    'name'  => 'publ',
                    'label' => 'Publication',
                    'fill'  => 'publ'
                ],
                [
                    'type'  => 'text',
                    'name'  => 'desc',
                    'label' => 'Description',
                    'fill'  => 'desc'
                ],
                [
                    'type'  => 'number',
                    'name'  => 'price',
                    'label' => 'Price',
                    'value' => 0.0,
                    'fill'  => 'price'
                ],
                [
                    'type'  => 'date',
                    'name'  => 'date',
                    'label' => 'Date of Purchase',
                    'fill'  => 'date'
                ],
                [
                    'type'  => 'number',
                    'name'  => 'amt',
                    'label' => 'No of Copies',
                    'value' => 1,
                    'required' => true,
                    'fill'  => 'amt'
                ],
                [
                    'type'  => 'text',
                    'name'  => 'sec',
                    'label' => 'Section',
                    'required' => true,
                    'fill'  => 'sec'
                ],
                [
                    'type'  => 'number',
                    'name'  => 'shelf',
                    'label' => 'shelf',
                    'required' => true,
                    'fill'  => 'shelf'
                ],
                [
                    'type'  => 'number',
                    'name'  => 'row',
                    'label' => 'Row',
                    'required' => true,
                    'fill'  => 'row'
                ]
            ]
        ],
        'filter' => [
            'title' => 'Filter Books',
            'action_button' => 'Filter',
            'close_button' => 'Cancel',
            'elms' => [
                [
                    'type'  => 'text',
                    'name'  => 'name',
                    'label' => 'Name'
                ],
                [
                    'type'  => 'text',
                    'name'  => 'author',
                    'label' => 'Author'
                ],
                [
                    'type'  => 'text',
                    'name'  => 'genre',
                    'label' => 'Genre'
                ],
                [
                    'type'  => 'text',
                    'name'  => 'category',
                    'label' => 'Category'
                ],
                [
                    'type'  => 'text',
                    'name'  => 'edition',
                    'label' => 'Edition'
                ],
                [
                    'type'  => 'text',
                    'name'  => 'isbn',
                    'label' => 'ISBN'
                ],
                [
                    'type'  => 'text',
                    'name'  => 'publ',
                    'label' => 'Publication'
                ],
                [
                    'type'  => 'text',
                    'name'  => 'desc',
                    'label' => 'Description'
                ],
                [
                    'type'  => 'number',
                    'name'  => 'price',
                    'label' => 'Price'
                ],
                [
                    'type'  => 'text',
                    'name'  => 'sec',
                    'label' => 'Section'
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
