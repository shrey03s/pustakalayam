<?php namespace App\Pages;

/**
 * Description of IssueRecord
 *
 * @author rajnish
 */
class IssueRecord 
{
    public $tabletitle = "Books Issuing Record";
    public $pageclass = "issue";
    public $pagesection = "issue";
    public $model = 'issue';
    public $order = 'ASC';
    public $getentries = "/api/entries";
    public $putentry = "/api/putentry";
    public $entrycount = '/api/entriesinfo';
    public $deleteentry = '/api/delete';
    
    public $tablefields = [
        'Member'         => ['mem.name' => 'text'],
        'Book'           => ['book.name' => 'text'],
        'Date'           => ['date' => 'date'],
        'Renewed'        => ['renewed' => 'bool'],
        'Exp Return Date'=> ['eret_date' => 'date'],
        'Return Date'    => ['aret_date' => 'date'],
        'Fine'           => ['fine' => 'decimal'],
        'Pay'            => ['paid' => 'decimal'],
        'Remaining'      => ['remain' => 'decimal'],
        'Paid'           => ['is_paid' => 'bool']
    ];
    public $orderfields = [
        'Member'         => ['field' => 'mem.name'],
        'Book'           => ['field' => 'book.name'],
        'Date'           => ['field' => 'date', 'selected' => true],
        'Renewed'        => ['field' => 'renewed'],
        'Fine'           => ['field' => 'fine'],
        'Pay'            => ['field' => 'paid'],
        'Remaining'      => ['field' => 'remain'],
        'Paid'           => ['field' => 'is_paid']
    ];
    public $searchfields = [
        'Member'         => 'mem.name',
        'Book'           => 'book.name',
        'Date'           => 'date',
        'Renewed'        => 'renewed',
        'Not Renewed'    => '!renewed',
        'Est Return Date'=> 'eret_date',
        'Return Date'    => 'aret_date',
        'Fine'           => 'fine',
        'Pay'            => 'paid',
        'Remaining'      => 'remain',
        'Paid'           => 'is_paid',
        'Not Paid'       => '!is_paid'
    ];
    public $modals = [
        'create'    => [
            'title' => 'Create Issue Entry',
            'action_button' => 'Create',
            'close_button'  => 'Cancel',
            'elms'  => [
                [
                    'type'  => 'varsel',
                    'name'  => 'mem_id',
                    'label' => 'Member',
                    'url'   => '/api/topresults',
                    'model' => 'members',
                    'field' => 'name',
                    'required' => true
                ],
                [
                    'type'  => 'varsel',
                    'name'  => 'book_id',
                    'label' => 'Book',
                    'url'   => '/api/topresults',
                    'model' => 'books',
                    'field' => 'name',
                    'required' => true
                ],
                [
                    'type'  => 'date',
                    'name'  => 'eret_date',
                    'label' => 'Expected Return Date'
                ],
                [
                    'type'  => 'date',
                    'name'  => 'date',
                    'label' => 'Date'
                ],
                [
                    'type'  => 'date',
                    'name'  => 'aret_date',
                    'label' => 'Actual Return Date'
                ],
                [
                    'type'  => 'number',
                    'name'  => 'addfine',
                    'label' => 'Fine'
                ],
                [
                    'type'  => 'number',
                    'name'  => 'paid',
                    'label' => 'Paid'
                ]
            ]
        ],
        'edit'      => [
            'title' => 'Edit Issue Entry',
            'action_button' => 'Edit',
            'close_button'  => 'Cancel',
            'elms'  => [
                [
                    'type'  => 'varsel',
                    'name'  => 'mem_id',
                    'label' => 'Member',
                    'url'   => '/api/topresults',
                    'model' => 'members',
                    'field' => 'name',
                    'required' => true,
                    'fill'  => ['input' => 'mem.name', 'hidden' => 'mem.id']
                ],
                [
                    'type'  => 'varsel',
                    'name'  => 'book_id',
                    'label' => 'Book',
                    'url'   => '/api/topresults',
                    'model' => 'books',
                    'field' => 'name',
                    'required' => true,
                    'fill'  => ['input' => 'book.name', 'hidden' => 'book.id']
                ],
                [
                    'type'  => 'date',
                    'name'  => 'eret_date',
                    'label' => 'Expected Return Date',
                    'fill'  => 'eret_date'
                ],
                [
                    'type'  => 'date',
                    'name'  => 'date',
                    'label' => 'Date',
                    'fill'  => 'date'
                ],
                [
                    'type'  => 'date',
                    'name'  => 'aret_date',
                    'label' => 'Actual Return Date',
                    'fill'  => 'aret_date'
                ],
                [
                    'type'  => 'number',
                    'name'  => 'addfine',
                    'label' => 'Fine',
                    'fill'  => 'addfine'
                ],
                [
                    'type'  => 'number',
                    'name'  => 'paid',
                    'label' => 'Paid',
                    'fill'  => 'paid'
                ]
            ]
        ],
        'filter' => [
            'title' => 'Filter Issue Entries',
            'action_button' => 'Filter',
            'close_button' => 'Cancel',
            'elms' => [
                [
                    'type'  => 'varsel',
                    'name'  => 'mem_id',
                    'label' => 'Member',
                    'url'   => '/api/topresults',
                    'model' => 'members',
                    'field' => 'name'
                ],
                [
                    'type'  => 'varsel',
                    'name'  => 'book_id',
                    'label' => 'Book',
                    'url'   => '/api/topresults',
                    'model' => 'books',
                    'field' => 'name'
                ]
            ]
        ],
        'details' => [
            'title' => 'Issue Entry Details',
            'action_button' => null,
            'close_button'  => 'Close',
            'elms'  => [
                'Member'            => [
                    'head'              => ['field' => 'mem.name', 'type' => 'text'],
                    'UID'               => ['field' => 'uid', 'type' => 'text'],
                    'Name'              => ['field' => 'name', 'type' => 'text'],
                    'Phone'             => ['field' => 'phone', 'type' => 'text'],
                    'Email'             => ['field' => 'email', 'type' => 'text'],
                    'Address'           => ['field' => 'address', 'type' => 'text'],
                    'City'              => ['field' => 'city', 'type' => 'text'],
                    'State'             => ['field' => 'state', 'type' => 'text'],
                    'Country'           => ['field' => 'country', 'type' => 'text'],
                    'Pin'               => ['field' => 'pin', 'type' => 'decimal'],
                    'Profession'        => ['field' => 'prof', 'type' => 'date'],
                    'Designation'       => ['field' => 'desg', 'type' => 'text'],
                    'Corp/Org'          => ['field' => 'corp', 'type' => 'number']
                ],
                'Book'              => [
                    'head'              => ['field' => 'book.name', 'type' => 'text'],
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
                ],
                'Renewed'               => ['field' => 'renewed', 'type' => 'bool'],
                'Date'                  => ['field' => 'date', 'type' => 'date'],
                'Expected Return Date'  => ['field' => 'eret_date', 'type' => 'date'],
                'Actual Return Date'    => ['field' => 'aret_date', 'type' => 'date'],
                'Added Fine'            => ['field' => 'addfine', 'type' => 'decimal'],
                'Fine'                  => ['field' => 'fine', 'type' => 'decimal'],
                'Paid'                  => ['field' => 'paid', 'type' => 'decimal'],
                'Remaining'             => ['field' => 'remain', 'type' => 'decimal'],
            ]
        ],
        'delete'    => [
            'title' => 'Delete Issue Entry',
            'action_button' => 'Delete',
            'close_button'  => 'Cancel',
            'elms'  => [
                [
                    'type'  => 'label',
                    'value' => 'Do you really want to delete the Book Issue entry?',
                ]
            ]
        ]
    ];
}
