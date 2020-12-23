<?php namespace App\Pages;

/**
 * Description of Renters
 *
 * @author rajnish
 */
class Renters 
{
    public $tabletitle = "Vehicle Renters Manager";
    public $pageclass = "renters";
    public $pagesection = "rent";
    public $model = 'renter';
    public $order = 'ASC';
    public $reqdata = true;
    public $getentries = "/api/entries";
    public $putentry = "/api/putentry";
    public $entrycount = '/api/entriesinfo';
    public $deleteentry = '/api/delete';
    
    public $tablefields = [
        'Name'              => ['name' => 'text'],
        'Profession'        => ['profession' => 'text'],
        'Phone'             => ['phone' => 'text'],
        'Email'             => ['email' => 'text'],
        'City'              => ['city' => 'text'],
        'State'             => ['state' => 'text']
    ];
    public $orderfields = [
        'Name'          => ['field' => 'name', 'selected' => true],
        'Profession'    => ['field' => 'profession'],
        'City'          => ['field' => 'city'],
        'State'         => ['field' => 'state'],
        'Phone'         => ['field' => 'phone'],
        'Email'         => ['field' => 'email']
    ];
    public $searchfields = [
        'Name'      => 'name',
        'Profession'=> 'profession',
        'Address'   => 'address',
        'City'      => 'city',
        'State'     => 'state',
        'Country'   => 'country',
        'Area Pin'  => 'area_pin',
        'Phone'     => 'phone',
        'Email'     => 'email',
        'Details'   => 'details'
    ];
    
    public $modals = [
        'create'    => [
            'title' => 'Add Vehicle Renter',
            'action_button' => 'Add',
            'close_button'  => 'Cancel',
            'elms'  => [
                [
                    'type'  => 'text',
                    'name'  => 'name',
                    'label' => 'Name',
                    'value' => '',
                    'required'  => true
                ],
                [
                    'type'  => 'text',
                    'name'  => 'profession',
                    'label' => 'Profession',
                    'value' => ''
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
                ],
                [
                    'type'  => 'table',
                    'name'  => 'details',
                    'label' => 'Details',
                    'th'    => ['Type','Value']
                ]
            ]
        ],
        'edit'      => [
            'title' => 'Edit Vehicle Renter',
            'action_button' => 'Edit',
            'close_button'  => 'Cancel',
            'elms'  => [
                [
                    'type'  => 'text',
                    'name'  => 'name',
                    'label' => 'Name',
                    'value' => '',
                    'required'  => true,
                    'fill'  => 'name'
                ],
                [
                    'type'  => 'text',
                    'name'  => 'profession',
                    'label' => 'Profession',
                    'value' => '',
                    'fill'  => 'profession'
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
                ],
                [
                    'type'  => 'table',
                    'name'  => 'details',
                    'label' => 'Details',
                    'th'    => ['Type','Value'],
                    'fill'  => ['table' => 'details', 'hidden' => 'details']
                ]
            ]
        ],
        'filter' => [
            'title' => 'Filter Renters',
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
                    'name'  => 'profession',
                    'label' => 'Profession'
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
                ]
            ]
        ],
        'details' => [
            'title' => 'Renter Details',
            'action_button' => null,
            'close_button'  => 'Close',
            'elms'  => [
                'Name'          => ['field' => 'name', 'type' => 'text'],
                'Profession'    => ['field' => 'profession', 'type' => 'text'],
                'Phone'         => ['field' => 'phone', 'type' => 'text'],
                'Email'         => ['field' => 'email', 'type' => 'text'],
                'Address'       => ['field' => 'address', 'type' => 'text'],
                'City'          => ['field' => 'city', 'type' => 'text'],
                'State'         => ['field' => 'state', 'type' => 'text'],
                'Country'       => ['field' => 'country', 'type' => 'text'],
                'Area Pin'      => ['field' => 'area_pin', 'type' => 'text'],
                'Other Details' => ['field' => 'details', 'type' => 'json']
            ]
        ],
        'delete'    => [
            'title' => 'Delete Vehicle Renter',
            'action_button' => 'Delete',
            'close_button'  => 'Cancel',
            'elms'  => [
                [
                    'type'  => 'label',
                    'value' => 'Do you really want to delete the Vehicle Renter ?',
                ]
            ]
        ]
    ];
}
