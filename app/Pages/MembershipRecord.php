<?php namespace App\Pages;

/**
 * Description of MembershipRecord
 *
 * @author rajnish
 */
class MembershipRecord 
{
    public $tabletitle = "Membership Record";
    public $pageclass = "membership";
    public $pagesection = "membership";
    public $model = 'membership';
    public $order = 'DESC';
    public $getentries = "/api/entries";
    public $putentry = "/api/putentry";
    public $entrycount = '/api/entriesinfo';
    public $deleteentry = '/api/delete';
    
    public $tablefields = [
        'Member'         => ['mem.name' => 'text'],
        'Date'           => ['date' => 'date'],
        'Valid Until'    => ['valid_until' => 'date'],
        'Charge'         => ['charge' => 'decimal'],
        'Payable'        => ['paid' => 'decimal'],
        'Remain'         => ['remain' => 'decimal'],
        'Paid'           => ['is_paid' => 'bool']
    ];
    public $orderfields = [
        'Member'         => ['field' => 'mem.name'],
        'Member UID'     => ['field' => 'mem.uid'],
        'Date'           => ['field' => 'date'],
        'Valid Until'    => ['field' => 'valid_until'],
        'Charge'         => ['field' => 'charge'],
        'Payable'        => ['field' => 'paid'],
        'Remain'         => ['field' => 'remain'],
        'Paid'           => ['field' => 'is_paid']
    ];
    public $searchfields = [
        'Member'         => 'mem.name',
        'Member UID'     => 'mem.uid',
        'Date'           => 'date',
        'Valid Until'    => 'valid_until',
        'Charge'         => 'charge',
        'Payable'        => 'paid',
        'Remain'         => 'remain',
        'Paid'           => 'is_paid',
        'UnPaid'         => '!is_paid'
    ];
    public $modals = [
        'create'    => [
            'title' => 'Create Membership Entry',
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
                    'type'  => 'date',
                    'name'  => 'date',
                    'label' => ' Date'
                ],
                [
                    'type'  => 'date',
                    'name'  => 'valid_until',
                    'label' => 'Valid Until',
                    'filldate' => false
                ],
                [
                    'type'  => 'number',
                    'name'  => 'charge',
                    'label' => 'Charge'
                ],
                [
                    'type'  => 'number',
                    'name'  => 'paid',
                    'label' => 'Paid'
                ]
            ]
        ],
        'edit'      => [
            'title' => 'Edit Membership Entry',
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
                    'type'  => 'date',
                    'name'  => 'date',
                    'label' => 'Date',
                    'fill'  => 'date'
                ],
                [
                    'type'  => 'date',
                    'name'  => 'valid_until',
                    'label' => 'Valid Until',
                    'filldate' => false,
                    'fill'  => 'valid_until'
                ],
                [
                    'type'  => 'number',
                    'name'  => 'charge',
                    'label' => 'Charge',
                    'fill'  => 'charge'
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
            'title' => 'Filter Membership Entries',
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
                    'type'  => 'date',
                    'name'  => 'date',
                    'label' => 'Date'
                ],
                [
                    'type'  => 'date',
                    'name'  => 'valid_until',
                    'label' => 'Valid Until',
                    'filldate' => false
                ],
                [
                    'type'  => 'number',
                    'name'  => 'charge',
                    'label' => 'Charge'
                ],
                [
                    'type'  => 'number',
                    'name'  => 'paid',
                    'label' => 'Paid'
                ]
            ]
        ],
        'details' => [
            'title' => 'Membership Entry Details',
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
                'Renewed'               => ['field' => 'renewed', 'type' => 'bool'],
                'Date'                  => ['field' => 'date', 'type' => 'date'],
                'Valid Until'           => ['field' => 'valid_until', 'type' => 'date'],
                'Charge'                => ['field' => 'charge', 'type' => 'decimal'],
                'Paid'                  => ['field' => 'paid', 'type' => 'decimal'],
                'Remaining'             => ['field' => 'remain', 'type' => 'decimal'],
            ]
        ],
        'delete'    => [
            'title' => 'Delete Membership Entry',
            'action_button' => 'Delete',
            'close_button'  => 'Cancel',
            'elms'  => [
                [
                    'type'  => 'label',
                    'value' => 'Do you really want to delete the Membership entry?',
                ]
            ]
        ]
    ];
}
