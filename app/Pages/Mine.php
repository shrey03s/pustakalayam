<?php namespace App\Pages;

/**
 * Description of Mine
 *
 * @author rajnish
 */
class Mine 
{
    public $tabletitle = "Mines Manager";
    public $pageclass = "mines";
    public $pagesection = "mining";
    public $model = 'mine';
    public $order = 'ASC';
    public $reqdata = true;
    public $getentries = "/api/entries";
    public $putentry = "/api/putentry";
    public $entrycount = '/api/entriesinfo';
    public $deleteentry = '/api/delete';
    
    public $tablefields = [
        'Name'              => ['name' => 'text'],
        'City'              => ['city' => 'text'],
        'State'             => ['state' => 'text']
    ];
    public $orderfields = [
        'Name'          => ['field' => 'name', 'selected' => true],
        'City'          => ['field' => 'city'],
        'State'         => ['field' => 'state']
    ];
    public $searchfields = [
        'Name'      => 'name',
        'Address'   => 'address',
        'City'      => 'city',
        'State'     => 'state',
        'Country'   => 'country',
        'Area Pin'  => 'area_pin'
    ];
    
    public $modals = [
        'create'    => [
            'title' => 'Add Mine',
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
            'title' => 'Edit Mine',
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
            'title' => 'Filter Mines',
            'action_button' => 'Filter',
            'close_button' => 'Cancel',
            'elms' => [
                [
                    'type'  => 'text',
                    'name' => 'name',
                    'label' => 'Name'
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
            'title' => 'Mine Details',
            'action_button' => null,
            'close_button'  => 'Close',
            'elms'  => [
                'Name'      => ['field' => 'name', 'type' => 'text'],
                'Address'   => ['field' => 'address', 'type' => 'text'],
                'City'      => ['field' => 'city', 'type' => 'text'],
                'State'     => ['field' => 'state', 'type' => 'text'],
                'Country'   => ['field' => 'country', 'type' => 'text'],
                'Area Pin'  => ['field' => 'area_pin', 'type' => 'text']
            ]
        ],
        'delete'    => [
            'title' => 'Delete Mine',
            'action_button' => 'Delete',
            'close_button'  => 'Cancel',
            'elms'  => [
                [
                    'type'  => 'label',
                    'value' => 'Do you really want to delete the Mine ?',
                ]
            ]
        ]
    ];
}
