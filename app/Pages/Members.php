<?php namespace App\Pages;

/**
 * Description of Members
 *
 * @author rajnish
 */
class Members 
{
    public $tabletitle = "Members";
    public $pageclass = "members";
    public $pagesection = "members";
    public $model = 'members';
    public $order = 'ASC';
    public $reqdata = true;
    public $getentries = "/api/entries";
    public $putentry = "/api/putentry";
    public $entrycount = '/api/entriesinfo';
    public $deleteentry = '/api/delete';
    
    public $tablefields = [
        'ID'             => ['id' => 'text'],
        'Name'           => ['name' => 'text'],
        'Phone'          => ['phone' => 'text'],
        'Email'          => ['email' => 'text'],
        'Profession'     => ['prof' => 'text'],
        'City'           => ['city' => 'text'],
        'State'          => ['state' => 'text']
    ];
    public $orderfields = [
        'ID'             => ['field' => 'id', 'selected' => true],
        'Name'           => ['field' => 'name'],
        'Phone'          => ['field' => 'phone'],
        'Email'          => ['field' => 'email'],
        'Profession'     => ['field' => 'prof'],
        'City'           => ['field' => 'city'],
        'State'          => ['field' => 'state']
    ];
    public $searchfields = [
        'ID'             => 'id',
        'Name'           => 'name',
        'Phone'          => 'phone',
        'Email'          => 'email',
        'Profession'     => 'prof',
        'City'           => 'city',
        'State'          => 'state',
        'Country'        => 'country',
        'Corp/Org'       => 'corp',
        'Designation'    => 'desg',
    ];
    public $modals = [
        'create'    => [
            'title' => 'Add Member',
            'action_button' => 'Add',
            'close_button'  => 'Cancel',
            'elms'  => [
                [
                    'type'  => 'text',
                    'name'  => 'id',
                    'label' => 'ID',
                    'required'  => true
                ],
                [
                    'type'  => 'text',
                    'name'  => 'name',
                    'label' => 'Name',
                    'required'  => true
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
                    'label' => 'Profession',
                    'required'  => true
                ],
                [
                    'type'  => 'text',
                    'name'  => 'desg',
                    'label' => 'Designation',
                    'required'  => true
                ],
                [
                    'type'  => 'text',
                    'name'  => 'corp',
                    'label' => 'Corporation/Organization/Institution',
                    'required' => true
                ]
            ]
        ],
        'edit'      => [
            'title' => 'Edit Member',
            'action_button' => 'Edit',
            'close_button'  => 'Cancel',
            'elms'  => [
                [
                    'type'  => 'text',
                    'name'  => 'id',
                    'label' => 'ID',
                    'required'  => true,
                    'fill'  => 'id'
                ],
                [
                    'type'  => 'text',
                    'name'  => 'name',
                    'label' => 'Name',
                    'required'  => true,
                    'fill'  => 'name'
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
                    'required'  => true,
                    'fill'  => 'prof'
                ],
                [
                    'type'  => 'text',
                    'name'  => 'desg',
                    'label' => 'Designation',
                    'required'  => true,
                    'fill'  => 'desg'
                ],
                [
                    'type'  => 'text',
                    'name'  => 'corp',
                    'label' => 'Corporation/Organization/Institution',
                    'required' => true,
                    'fill'  => 'corp'
                ]
            ]
        ],
        'filter' => [
            'title' => 'Filter Members',
            'action_button' => 'Filter',
            'close_button' => 'Cancel',
            'elms' => [
                [
                    'type'  => 'text',
                    'name'  => 'id',
                    'label' => 'ID'
                ],
                [
                    'type'  => 'text',
                    'name'  => 'name',
                    'label' => 'Name'
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
                ]
            ]
        ],
        'details' => [
            'title' => 'Member Details',
            'action_button' => null,
            'close_button'  => 'Close',
            'elms'  => [
                'ID'                => ['field' => 'id', 'type' => 'text'],
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
            ]
        ],
        'delete'    => [
            'title' => 'Delete Member',
            'action_button' => 'Delete',
            'close_button'  => 'Cancel',
            'elms'  => [
                [
                    'type'  => 'label',
                    'value' => 'Do you really want to delete the Member?',
                ]
            ]
        ]
    ];
}
