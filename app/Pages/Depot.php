<?php namespace App\Pages;

/**
 * Description of Depot
 *
 * @author rajnish
 */
class Depot 
{
    public $tabletitle = "Depots Manager";
    public $pageclass = "depots";
    public $pagesection = "mining";
    public $model = 'depot';
    public $order = 'ASC';
    public $reqdata = true;
    public $getentries = "/api/entries";
    public $putentry = "/api/putentry";
    public $entrycount = '/api/entriesinfo';
    public $deleteentry = '/api/delete';
    
    public $tablefields = [
        'Name'              => ['name' => 'text'],
        'Incharge'          => ['incharge' => 'text'],
        'Phone'             => ['phone' => 'text'],
        'Email'             => ['email' => 'text'],
        'City'              => ['city' => 'text'],
        'State'             => ['state' => 'text']
    ];
    public $orderfields = [
        'Name'          => ['field' => 'name', 'selected' => true],
        'Incharge'      => ['field' => 'incharge'],
        'City'          => ['field' => 'city'],
        'State'         => ['field' => 'state'],
        'Phone'         => ['field' => 'phone'],
        'Email'         => ['field' => 'email']
    ];
    public $searchfields = [
        'Name'      => 'name',
        'Incharge'  => 'incharge',
        'Address'   => 'address',
        'City'      => 'city',
        'State'     => 'state',
        'Country'   => 'country',
        'Area Pin'  => 'area_pin',
        'Phone'     => 'phone',
        'Email'     => 'email'
    ];
    
    public $modals = [
        'create'    => [
            'title' => 'Add Depot',
            'action_button' => 'Add',
            'close_button'  => 'Cancel',
            'elms'  => [
                [
                    'type'  => 'text',
                    'name'  => 'name',
                    'label' => 'Name',
                    'required' => true
                ],
                [
                    'type'  => 'text',
                    'name'  => 'incharge',
                    'label' => 'Incharge',
                    'required' => true
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
                    'pin_name'      => 'area_pin'
                ]
            ]
        ],
        'edit'      => [
            'title' => 'Edit Depot',
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
                    'type'  => 'text',
                    'name'  => 'incharge',
                    'label' => 'Incharge',
                    'required' => true,
                    'fill'  => 'incharge'
                ],
                [
                    'type'  => 'text',
                    'name'  => 'phone',
                    'label' => 'Phone',
                    'fill'  => 'phone'
                ],
                [
                    'type'  => 'text',
                    'name'  => 'email',
                    'label' => 'Email',
                    'fill'  => 'email'
                ],
                [
                    'type'          => 'address',
                    'address_name'  => 'address',
                    'country_name'  => 'country',
                    'state_name'    => 'state',
                    'city_name'     => 'city',
                    'pin_name'      => 'area_pin',
                    'fill'          => [
                        'address'   => 'address',
                        'country'   => 'country',
                        'state'     => 'state',
                        'city'      => 'city',
                        'pin'       => 'area_pin'
                    ]
                ]
            ]
        ],
        'filter' => [
            'title' => 'Filter Depots',
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
                    'name'  => 'incharge',
                    'label' => 'Incharge'
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
                    'pin_name'      => 'area_pin'
                ],
                [
                    'type'  => 'text',
                    'name'  => 'rawamt',
                    'label' => 'Raw Coal Amount'
                ],
                [
                    'type'  => 'text',
                    'name'  => 'cookamt',
                    'label' => 'Processed Coal Amount'
                ]
            ]
        ],
        'details' => [
            'title' => 'Depot Details',
            'action_button' => null,
            'close_button'  => 'Close',
            'elms'  => [
                'Name'      => ['field' => 'name', 'type' => 'text'],
                'Incharge'  => ['field' => 'incharge', 'type' => 'text'],
                'Phone'     => ['field' => 'phone', 'type' => 'text'],
                'Email'     => ['field' => 'email', 'type' => 'text'],
                'Address'   => ['field' => 'address', 'type' => 'text'],
                'City'      => ['field' => 'city', 'type' => 'text'],
                'State'     => ['field' => 'state', 'type' => 'text'],
                'Country'   => ['field' => 'country', 'type' => 'text'],
                'Area Pin'  => ['field' => 'area_pin', 'type' => 'text'],
                'Raw Coal'  => ['field' => 'rawamt', 'type' => 'decimal'],
                'Cooked Coal'  => ['field' => 'cookamt', 'type' => 'decimal']
            ]
        ],
        'delete'    => [
            'title' => 'Delete Depot',
            'action_button' => 'Delete',
            'close_button'  => 'Cancel',
            'elms'  => [
                [
                    'type'  => 'label',
                    'value' => 'Do you really want to delete the Depot ?',
                ]
            ]
        ]
    ];
}
