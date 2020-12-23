<?php namespace App\Pages;

/**
 * Description of Vehicles
 *
 * @author rajnish
 */
class Vehicles 
{
    public $tabletitle = "Vehicles Manager";
    public $pageclass = "vehicles";
    public $pagesection = "vehicles";
    public $model = 'vehicles';
    public $order = 'ASC';
    public $getentries = "/api/entries";
    public $putentry = "/api/putentry";
    public $entrycount = '/api/entriesinfo';
    public $deleteentry = '/api/delete';
    
    public $tablefields = [
        'VIN'            => ['vin' => 'text'],
        'Type'           => ['type' => 'text'],
        'Date Purchase'  => ['date' => 'date']
    ];
    public $orderfields = [
        'VIN'            => ['field' => 'vin', 'selected' => true],
        'Type'           => ['field' => 'type'],
        'Date Purchase'  => ['field' => 'date']
    ];
    public $searchfields = [
        'VIN'   => 'vin',
        'Type'  => 'type'
    ];
    public $modals = [
        'create'    => [
            'title' => 'Add Vehicle',
            'action_button' => 'Add',
            'close_button'  => 'Cancel',
            'elms'  => [
                [
                    'type'  => 'text',
                    'name'  => 'vin',
                    'label' => 'Vehicle ID Number (VIN)',
                    'required'  => true
                ],
                [
                    'type'  => 'text',
                    'name'  => 'type',
                    'label' => 'Vehicle Type',
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
            'title' => 'Edit Vehicle',
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
            'title' => 'Vehicle Details',
            'action_button' => null,
            'close_button'  => 'Close',
            'elms'  => [
                'Vehicle Identification Number (VIN)' => ['field' => 'vin', 'type' => 'text'],
                'Vehicle Type' => ['field' => 'type', 'type' => 'text'],
                'Vehicle Purchase Date' => ['field' => 'date', 'type' => 'date']
            ]
        ],
        'delete'    => [
            'title' => 'Delete Vehicle',
            'action_button' => 'Delete',
            'close_button'  => 'Cancel',
            'elms'  => [
                [
                    'type'  => 'label',
                    'value' => 'Do you really want to delete the Vehicle ?',
                ]
            ]
        ]
    ];
}
