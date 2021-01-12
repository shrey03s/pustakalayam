<?php namespace App\Pages;

/**
 * Description of VisitorsRecord
 *
 * @author rajnish
 */
class VisitorsRecord 
{
    public $tabletitle = "Visitors Record";
    public $pageclass = "visitors";
    public $pagesection = "visitors";
    public $model = 'visitors';
    public $order = 'DESC';
    public $reqdata = true;
    public $getentries = "/api/entries";
    public $putentry = "/api/putentry";
    public $entrycount = '/api/entriesinfo';
    public $deleteentry = '/api/delete';
    
    public $tablefields = [
        'Name'           => ['name' => 'text'],
        'Member'         => ['mem.uid' => 'text'],
        'Book'           => ['book.name' => 'text'],
        'Phone'          => ['phone' => 'text'],
        'Email'          => ['email' => 'text'],
        'Profession'     => ['prof' => 'text'],
        'City'           => ['city' => 'text'],
        'State'          => ['state' => 'text'],
        'Time'           => ['time_in' => 'datetime'],
        'Return'         => ['time_out' => 'datetime'],
        'Charge'         => ['charge' => 'decimal']
    ];
    public $orderfields = [
        'Name'           => ['field' => 'name'],
        'Member'         => ['field' => 'mem.uid'],
        'Book'           => ['field' => 'book.name'],
        'Phone'          => ['field' => 'phone'],
        'Email'          => ['field' => 'email'],
        'Profession'     => ['field' => 'prof'],
        'City'           => ['field' => 'city'],
        'State'          => ['field' => 'state'],
        'Time'           => ['field' => 'time_in'],
        'Return'         => ['field' => 'time_out'],
        'Charge'         => ['field' => 'charge']
    ];
    public $searchfields = [
        'Name'           => 'name',
        'Member'         => 'mem.uid',
        'Book'           => 'book.name',
        'Phone'          => 'phone',
        'Email'          => 'email',
        'Profession'     => 'prof',
        'City'           => 'city',
        'State'          => 'state',
        'Country'        => 'country',
        'Pin'            => 'pin',
        'Time'           => 'time_in',
        'Return'         => 'time_out',
        'Charge'         => 'charge'
    ];
    public $modals = [
        'create'    => [
            'title' => 'Create Visitor Entry',
            'action_button' => 'Create',
            'close_button'  => 'Cancel',
            'elms'  => [
                [
                    'type'  => 'text',
                    'name'  => 'name',
                    'label' => 'Name',
                    'required' => true
                ],
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
                    'field' => 'name',
                    'required' => true
                ],
                [
                    'type'  => 'text',
                    'name'  => 'phone',
                    'label' => 'Phone',
                    'required' => true
                ],
                [
                    'type'  => 'text',
                    'name'  => 'email',
                    'label' => 'Email',
                    'required' => true
                ],
                [
                    'type'          => 'address',
                    'address_name'  => 'address',
                    'country_name'  => 'country',
                    'state_name'    => 'state',
                    'city_name'     => 'city',
                    'pin_name'      => 'pin'
                ],
                [
                    'type'  => 'text',
                    'name'  => 'prof',
                    'label' => 'Profession'
                ],
                [
                    'type'  => 'text',
                    'name'  => 'desg',
                    'label' => 'Designation'
                ],
                [
                    'type'  => 'text',
                    'name'  => 'corp',
                    'label' => 'Corporation/Organization/Institution'
                ],
                [
                    'type'  => 'datetime',
                    'name'  => 'time_in',
                    'label' => 'Time'
                ],
                [
                    'type'  => 'datetime',
                    'name'  => 'time_out',
                    'label' => 'Return'
                ],
                [
                    'type'  => 'number',
                    'name'  => 'charge',
                    'label' => 'Charge'
                ]
            ]
        ],
        'edit'      => [
            'title' => 'Edit Visitor Entry',
            'action_button' => 'Edit',
            'close_button'  => 'Cancel',
            'elms'  => [
                [
                    'type'  => 'text',
                    'name'  => 'name',
                    'label' => 'Name',
                    'required' => true,
                    'fill'  => 'name'
                ],
                [
                    'type'  => 'varsel',
                    'name'  => 'mem_id',
                    'label' => 'Member',
                    'url'   => '/api/topresults',
                    'model' => 'members',
                    'field' => 'name',
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
                    'type'  => 'text',
                    'name'  => 'phone',
                    'label' => 'Phone',
                    'required' => true,
                    'fill'  => 'phone'
                ],
                [
                    'type'  => 'text',
                    'name'  => 'email',
                    'label' => 'Email',
                    'required' => true,
                    'fill'  => 'email'
                ],
                [
                    'type'          => 'address',
                    'address_name'  => 'address',
                    'country_name'  => 'country',
                    'state_name'    => 'state',
                    'city_name'     => 'city',
                    'pin_name'      => 'pin',
                    'fill'          => [
                        'address'   => 'address',
                        'country'   => 'country',
                        'state'     => 'state',
                        'city'      => 'city',
                        'pin'       => 'pin'
                    ]
                ],
                [
                    'type'  => 'text',
                    'name'  => 'prof',
                    'label' => 'Profession',
                    'fill'  => 'profession'
                ],
                [
                    'type'  => 'text',
                    'name'  => 'desg',
                    'label' => 'Designation',
                    'fill'  => 'desg'
                ],
                [
                    'type'  => 'text',
                    'name'  => 'corp',
                    'label' => 'Corporation/Organization/Institution',
                    'fill'  => 'corp'
                ],
                [
                    'type'  => 'datetime',
                    'name'  => 'time_in',
                    'label' => 'Time',
                    'fill'  => 'time_in'
                ],
                [
                    'type'  => 'datetime',
                    'name'  => 'time_out',
                    'label' => 'Return',
                    'fill'  => 'time_out'
                ],
                [
                    'type'  => 'number',
                    'name'  => 'charge',
                    'label' => 'Charge',
                    'fill'  => 'charge'
                ]
            ]
        ],
        'filter' => [
            'title' => 'Filter Visitor Entries',
            'action_button' => 'Filter',
            'close_button' => 'Cancel',
            'elms' => [
                [
                    'type'  => 'text',
                    'name'  => 'name',
                    'label' => 'Name'
                ],
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
                ],
                [
                    'type'  => 'text',
                    'name'  => 'phone',
                    'label' => 'Phone'
                ],
                [
                    'type'  => 'text',
                    'name'  => 'email',
                    'label' => 'Email'
                ],
                [
                    'type'          => 'address',
                    'address_name'  => 'address',
                    'country_name'  => 'country',
                    'state_name'    => 'state',
                    'city_name'     => 'city',
                    'pin_name'      => 'pin'
                ],
                [
                    'type'  => 'text',
                    'name'  => 'prof',
                    'label' => 'Profession'
                ],
                [
                    'type'  => 'text',
                    'name'  => 'desg',
                    'label' => 'Designation'
                ],
                [
                    'type'  => 'text',
                    'name'  => 'corp',
                    'label' => 'Corporation/Organization/Institution'
                ],
                [
                    'type'  => 'datetime',
                    'name'  => 'time_in',
                    'label' => 'Time'
                ],
                [
                    'type'  => 'datetime',
                    'name'  => 'time_out',
                    'label' => 'Return'
                ],
                [
                    'type'  => 'number',
                    'name'  => 'charge',
                    'label' => 'Charge'
                ]
            ]
        ],
        'details' => [
            'title' => 'Visitor Entry Details',
            'action_button' => null,
            'close_button'  => 'Close',
            'elms'  => [
                'Name'                  => ['field' => 'mem.uid', 'type' => 'text'],
                'Member'            => [
                    'head'              => ['field' => 'mem.uid', 'type' => 'text'],
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
                'Phone'                 => ['field' => 'phone', 'type' => 'text'],
                'Email'                 => ['field' => 'email', 'type' => 'text'],
                'Address'               => ['field' => 'address', 'type' => 'text'],
                'City'                  => ['field' => 'city', 'type' => 'text'],
                'State'                 => ['field' => 'state', 'type' => 'text'],
                'Country'               => ['field' => 'country', 'type' => 'text'],
                'Pin'                   => ['field' => 'pin', 'type' => 'decimal'],
                'Profession'            => ['field' => 'prof', 'type' => 'text'],
                'Designation'           => ['field' => 'desg', 'type' => 'text'],
                'Corp/Org'              => ['field' => 'corp', 'type' => 'number'],
                'Time'                  => ['field' => 'time_in', 'type' => 'text'],
                'Return'                => ['field' => 'time_out', 'type' => 'text'],
                'Charge'                => ['field' => 'country', 'type' => 'text']
            ]
        ],
        'delete'    => [
            'title' => 'Delete Visitor Entry',
            'action_button' => 'Delete',
            'close_button'  => 'Cancel',
            'elms'  => [
                [
                    'type'  => 'label',
                    'value' => 'Do you really want to delete the Visitor entry?',
                ]
            ]
        ]
    ];
}
