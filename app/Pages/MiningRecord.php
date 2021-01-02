<?php namespace App\Pages;

/**
 * Description of MiningRecord
 *
 * @author rajnish
 */
class MiningRecord 
{
    public $tabletitle = "Books";
    public $pageclass = "mining";
    public $pagesection = "mining";
    public $model = "mining";
    public $order = 'DESC';
    public $getentries = "/api/entries";
    public $putentry = "/api/putentry";
    public $entrycount = '/api/entriesinfo';
    public $deleteentry = '/api/delete';
    
    public $tablefields = [
        'Vehicle'       => ['vehicle.vin' => 'text'],
        'Mine'          => ['mine.name' => 'text'],
        'Depot'         => ['depot.name' => 'text'],
        'Amount (tons)' => ['amount' => 'decimal'],
        'Rate'          => ['rate' => 'decimal'],
        'Price'         => ['price' => 'decimal'],
        'Expenses'      => ['expensesum' => 'decimal'],
        'Gross'         => ['gross' => 'decimal'],
        'Date'          => ['date' => 'date']
    ];
    public $orderfields = [
        'Date'          => ['field' => 'date', 'selected' => true],
        'Auth'          => ['field' => 'vehicle.vin'],
        'Edition'       => ['field' => 'mine.name'],
        'Depot'         => ['field' => 'depot.name'],
        'Amount'        => ['field' => 'amount'],
        'Rate'          => ['field' => 'rate'],
        'Price'         => ['field' => 'price'],
        'Expenses'      => ['field' => 'expensesum'],
        'Gross'         => ['field' => 'gross']
    ];
    public $searchfields = [
        'Vehicle VIN'       => 'vehicle.vin',
        'Vehicle Type'      => 'vehicle.type',
        'Mine'              => 'mine.name',
        'Mine City'         => 'mine.city',
        'Mine State'        => 'mine.state',
        'Depot'             => 'depot.name',
        'Depot Incharge'    => 'depot.incharge',
        'Depot City'        => 'depot.city',
        'Depot State'       => 'depot.state',
        'Expenses'          => 'expenses'
    ];
    
    public $modals = [
        'create'    => [
            'title' => 'Create Mining Entry',
            'action_button' => 'Create',
            'close_button'  => 'Cancel',
            'elms'  => [
                [
                    'type'  => 'varsel',
                    'name'  => 'vehicle_id',
                    'label' => 'Vehicle',
                    'url'   => '/api/topresults',
                    'model' => 'vehicles',
                    'field' => 'vin',
                    'required' => true
                ],
                [
                    'type'  => 'varsel',
                    'name'  => 'mine_id',
                    'label' => 'Mine',
                    'url'   => '/api/topresults',
                    'model' => 'mine',
                    'field' => 'name',
                    'required' => true
                ],
                [
                    'type'  => 'varsel',
                    'name'  => 'depot_id',
                    'label' => 'Depot',
                    'url'   => '/api/topresults',
                    'model' => 'depot',
                    'field' => 'name',
                    'required' => true
                ],
                [
                    'type'  => 'coal',
                    'name'  => 'amount',
                    'label' => 'Amount of Coal',
                    'id'    => 'mining-create-amount',
                    'onchange' => "setv('#mining-create-price', mul('#mining-create-amount', '#mining-create-rate'))",
                    'required' => true
                ],
                [
                    'type'  => 'number',
                    'name'  => 'rate',
                    'label' => 'Price Rate',
                    'id'    => 'mining-create-rate',
                    'onchange' => "setv('#mining-create-price', mul('#mining-create-amount', '#mining-create-rate'))",
                    'required' => true
                ],
                [
                    'type'  => 'calc',
                    'name'  => 'price',
                    'label' => 'Total Price',
                    'id'    => 'mining-create-price',
                    'value' => '0.00'
                ],
                [
                    'type'      => 'table',
                    'name'      => 'expenses',
                    'label'     => 'Expenses',
                    'keytype'   => 'text',
                    'valuetype' => 'number',
                    'th'        => ['Type','Amount']
                ],
                [
                    'type'  => 'date',
                    'name'  => 'date',
                    'label' => 'Date',
                    'required' => true
                ]
            ]
        ],
        'edit'      => [
            'title' => 'Edit Mining Entry',
            'action_button' => 'Edit',
            'close_button'  => 'Cancel',
            'elms'  => [
                [
                    'type'  => 'varsel',
                    'name'  => 'vehicle_id',
                    'label' => 'Vehicle',
                    'url'   => '/api/topresults',
                    'model' => 'vehicles',
                    'field' => 'vin',
                    'required' => true,
                    'fill'  => ['input' => 'vehicle.vin', 'hidden' => 'vehicle.id']
                ],
                [
                    'type'  => 'varsel',
                    'name'  => 'mine_id',
                    'label' => 'Vehicle Renter',
                    'url'   => '/api/topresults',
                    'model' => 'mine',
                    'field' => 'name',
                    'required' => true,
                    'fill'  => ['input' => 'mine.name', 'hidden' => 'mine.id']
                ],
                [
                    'type'  => 'varsel',
                    'name'  => 'depot_id',
                    'label' => 'Depot',
                    'url'   => '/api/topresults',
                    'model' => 'depot',
                    'field' => 'name',
                    'required' => true,
                    'fill'  => ['input' => 'depot.name', 'hidden' => 'depot.id']
                ],
                [
                    'type'  => 'number',
                    'name'  => 'amount',
                    'label' => 'Amount',
                    'id'    => 'mining-edit-amount',
                    'onchange' => "setv('#mining-edit-price', mul('#mining-edit-amount', '#mining-edit-rate'))",
                    'required' => true,
                    'fill'  => 'amount'
                ],
                [
                    'type'  => 'number',
                    'name'  => 'rate',
                    'label' => 'Price Rate',
                    'id'    => 'mining-edit-rate',
                    'onchange' => "setv('#mining-edit-price', mul('#mining-edit-amount', '#mining-edit-rate'))",
                    'required' => true,
                    'fill'  => 'rate'
                ],
                [
                    'type'  => 'calc',
                    'name'  => 'cost',
                    'label' => 'Total Price',
                    'id'    => 'mining-edit-price',
                    'value' => '0.00',
                    'fill'  => 'price'
                ],
                [
                    'type'      => 'table',
                    'name'      => 'expenses',
                    'label'     => 'Expenses',
                    'keytype'   => 'text',
                    'valuetype' => 'number',
                    'th'        => ['Type','Amount'],
                    'fill'      => ['table' => 'expenses', 'hidden' => 'expenses']
                ],
                [
                    'type'  => 'date',
                    'name'  => 'date',
                    'label' => 'Date',
                    'required' => true,
                    'fill'  => 'date'
                ]
            ]
        ],
        'filter' => [
            'title' => 'Filter Mining Entries',
            'action_button' => 'Filter',
            'close_button' => 'Cancel',
            'elms' => [
                [
                    'type'  => 'varsel',
                    'name'  => 'vehicle_id',
                    'label' => 'Vehicle',
                    'url'   => '/api/topresults',
                    'model' => 'vehicles',
                    'field' => 'vin'
                ],
                [
                    'type'  => 'varsel',
                    'name'  => 'mine_id',
                    'label' => 'Mine',
                    'url'   => '/api/topresults',
                    'model' => 'mine',
                    'field' => 'name'
                ],
                [
                    'type'  => 'varsel',
                    'name'  => 'depot_id',
                    'label' => 'Depot',
                    'url'   => '/api/topresults',
                    'model' => 'depot',
                    'field' => 'name'
                ],
                [
                    'type'  => 'text',
                    'name'  => 'amount',
                    'label' => 'Amount of Coal'
                ],
                [
                    'type'  => 'text',
                    'name'  => 'rate',
                    'label' => 'Price Rate'
                ],
                [
                    'type'  => 'text',
                    'name'  => 'price',
                    'label' => 'Total Price'
                ],
                [
                    'type'  => 'text',
                    'name'  => 'expensesum',
                    'label' => 'Expenses'
                ],
                [
                    'type'  => 'text',
                    'name'  => 'gross',
                    'label' => 'Gross'
                ]
            ]
        ],
        'details' => [
            'title' => 'Mining Entry Details',
            'action_button' => null,
            'close_button'  => 'Close',
            'elms'  => [
                'Vehicle' => [
                    'head' => ['field' => 'vehicle.vin', 'type' => 'text'],
                    'Vehicle Identification Number (VIN)' => ['field' => 'vehicle.vin', 'type' => 'text'],
                    'Vehicle Type' => ['field' => 'vehicle.type', 'type' => 'text'],
                    'Vehicle Purchase Date' => ['field' => 'vehicle.date', 'type' => 'date']
                ],
                'Mine' => [
                    'head'      => ['field' => 'mine.name', 'type' => 'text'],
                    'Address'   => ['field' => 'mine.address', 'type' => 'text'],
                    'City'      => ['field' => 'mine.city', 'type' => 'text'],
                    'State'     => ['field' => 'mine.state', 'type' => 'text'],
                    'Country'   => ['field' => 'mine.country', 'type' => 'text'],
                    'Area Pin'  => ['field' => 'mine.area_pin', 'type' => 'text']
                ],
                'Depot' => [
                    'head'      => ['field' => 'depot.name', 'type' => 'text'],
                    'Incharge'  => ['field' => 'depot.incharge', 'type' => 'text'],
                    'Phone'     => ['field' => 'depot.phone', 'type' => 'text'],
                    'Email'     => ['field' => 'depot.email', 'type' => 'text'],
                    'Address'   => ['field' => 'depot.address', 'type' => 'text'],
                    'City'      => ['field' => 'depot.city', 'type' => 'text'],
                    'State'     => ['field' => 'depot.state', 'type' => 'text'],
                    'Country'   => ['field' => 'depot.country', 'type' => 'text'],
                    'Area Pin'  => ['field' => 'depot.area_pin', 'type' => 'text']
                ],
                'Amount of Coal (tons)' => ['field' => 'amount', 'type' => 'decimal'],
                'Price Rate'            => ['field' => 'rate', 'type' => 'decimal'],
                'Total Price'           => ['field' => 'price', 'type' => 'decimal'],
                'Expenses Sum'          => ['field' => 'expensesum', 'type' => 'decimal'],
                'Gross'                 => ['field' => 'gross', 'type' => 'decimal'],
                'Expenses Details'      => ['field' => 'expenses', 'type' => 'json'],
                'Date'                  => ['field' => 'date', 'type' => 'date']
            ]
        ],
        'delete'    => [
            'title' => 'Delete Mining Entry',
            'action_button' => 'Delete',
            'close_button'  => 'Cancel',
            'elms'  => [
                [
                    'type' => 'label',
                    'value' => 'Do you really want to delete the Mining entry?',
                ]
            ]
        ]
    ];
}
