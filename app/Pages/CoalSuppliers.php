<?php namespace App\Pages;

/**
 * Description of CoalSuppliers
 *
 * @author rajnish
 */
class CoalSuppliers 
{
    public $tabletitle = "Coal Supplier Manager";
    public $pageclass = "suppliers";
    public $pagesection = "utility";
    public $model = 'coalSupplier';
    public $order = 'ASC';
    public $reqdata = true;
    public $getentries = "/api/entries";
    public $putentry = "/api/putentry";
    public $entrycount = '/api/entriesinfo';
    public $deleteentry = '/api/delete';
    
    public $tablefields = [
        'Name'          => ['name' => 'text'],
        'Company/Farm'  => ['corpname' => 'text'],
        'Phone'         => ['phone' => 'text'],
        'Email'         => ['email' => 'text'],
        'GSTIN'         => ['gstin' => 'text'],
        'City'          => ['city' => 'text'],
        'State'         => ['state' => 'text']
    ];
    public $orderfields = [
        'Name'          => ['field' => 'name', 'selected' => true],
        'Company/Farm'  => ['field' => 'corpname'],
        'Phone'         => ['field' => 'phone'],
        'Email'         => ['field' => 'email'],
        'GSTIN'         => ['field' => 'gstin'],
        'City'          => ['field' => 'city'],
        'State'         => ['field' => 'state']
    ];
    public $searchfields = [
        'Name'          => 'name',
        'Company/Farm'  => 'corpname',
        'Address'       => 'address',
        'City'          => 'city',
        'State'         => 'state',
        'Country'       => 'country',
        'Area Pin'      => 'area_pin',
        'Phone'         => 'phone',
        'Email'         => 'email',
        'GSTIN'         => 'gstin',
        'Details'       => 'details'
    ];
    
    public $modals = [
        'create'    => [
            'title' => 'Add Supplier',
            'action_button' => 'Add',
            'close_button'  => 'Cancel',
            'elms'  => [
                [
                    'type'  => 'text',
                    'name'  => 'name',
                    'label' => 'Name',
                    'value' => '',
                    'required' => true
                ],
                [
                    'type'  => 'text',
                    'name'  => 'corpname',
                    'label' => 'Company/Farm Name',
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
                    'type'  => 'text',
                    'name'  => 'gstin',
                    'label' => 'GSTIN'
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
            'title' => 'Edit Supplier',
            'action_button' => 'Edit',
            'close_button'  => 'Cancel',
            'elms'  => [
                [
                    'type'  => 'text',
                    'name'  => 'name',
                    'label' => 'Name',
                    'value' => '',
                    'required' => true,
                    'fill'  => 'name'
                ],
                [
                    'type'  => 'text',
                    'name'  => 'corpname',
                    'label' => 'Company/Farm Name',
                    'value' => '',
                    'fill'  => 'corpname'
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
                    'type'  => 'text',
                    'name'  => 'gstin',
                    'label' => 'GSTIN',
                    'fill'  => 'gstin'
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
            'title' => 'Filter Suppliers',
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
                    'name'  => 'corpname',
                    'label' => 'Company/Farm Name'
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
                    'type'  => 'text',
                    'name'  => 'gstin',
                    'label' => 'GSTIN'
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
            'title' => "Coal Supplier's Details",
            'action_button' => null,
            'close_button'  => 'Close',
            'elms'  => [
                'Name'          => ['field' => 'name', 'type' => 'text'],
                'Company/Farm'  => ['field' => 'corpname', 'type' => 'text'],
                'GSTIN'         => ['field' => 'gstin', 'type' => 'text'],
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
            'title' => 'Delete Supplier',
            'action_button' => 'Delete',
            'close_button'  => 'Cancel',
            'elms'  => [
                [
                    'type'  => 'label',
                    'value' => 'Do you really want to delete the coal supplier?',
                ]
            ]
        ]
    ];
}
