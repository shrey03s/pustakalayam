<?php namespace App\Pages;

/**
 * Description of CoalPurchasedRecord
 *
 * @author rajnish
 */
class CoalPurchasedRecord 
{
    public $tabletitle = "Coal Purchase Manager";
    public $pageclass = "purchased";
    public $pagesection = "utility";
    public $model = "coalPurchased";
    public $order = 'DESC';
    public $getentries = "/api/entries";
    public $putentry = "/api/putentry";
    public $entrycount = '/api/entriesinfo';
    public $deleteentry = '/api/delete';
    
    public $tablefields = [
        'Supplier'          => ['supplier.name' => 'text'],
        'Amount (tons)'     => ['amount' => 'decimal'],
        'Rate'              => ['rate' => 'decimal'],
        'Price'             => ['price' => 'decimal'],
        'Depot'             => ['depot.name' => 'text'],
        'Processed/Raw'     => ['is_processed' => 'bool'],
        'Date'              => ['date' => 'date']
    ];
    public $orderfields = [
        'Date'            => ['field' => 'date', 'selected' => true],
        'Supplier'        => ['field' => 'supplier.name'],
        'Depot'           => ['field' => 'depot.name'],
        'Amount'          => ['field' => 'amount'],
        'Rate'            => ['field' => 'rate'],
        'Price'           => ['field' => 'price'],
        'Processed/Raw'   => ['field' => 'is_processed']
    ];
    public $searchfields = [
        'Supplier'          => 'supplier.name',
        'Supplier City'     => 'supplier.city',
        'Supplier State'    => 'supplier.state',
        'Supplier Phone'    => 'supplier.phone',
        'Supplier Email'    => 'supplier.email',
        'Supplier GSTIN'    => 'supplier.gstin',
        'Supplier Details'  => 'supplier.details',
        'Depot'             => 'depot.name',
        'Depot Incharge'    => 'depot.incharge',
        'Depot City'        => 'depot.city',
        'Depot State'       => 'depot.state',
        'Processed'         => 'is_processed',
        'Raw'               => '!is_processed'
    ];
    public $modals = [
        'create'    => [
            'title' => 'Create Coal Purchase Entry',
            'action_button' => 'Create',
            'close_button'  => 'Cancel',
            'elms'  => [
                [
                    'type'  => 'varsel',
                    'name'  => 'supplier_id',
                    'label' => 'Coal Supplier',
                    'url'   => '/api/topresults',
                    'model' => 'coalSupplier',
                    'field' => 'name',
                    'required' => true
                ],
                [
                    'type'  => 'coal',
                    'name'  => 'amount',
                    'label' => 'Amount of Coal',
                    'id'    => 'cpr-create-amount',
                    'onchange' => "setv('#cpr-create-price', mul('#cpr-create-amount', '#cpr-create-rate'))",
                    'required' => true
                ],
                [
                    'type'  => 'check',
                    'name'  => 'is_processed',
                    'label' => 'Processed',
                    'required' => true
                ],
                [
                    'type'  => 'number',
                    'name'  => 'rate',
                    'label' => 'Price Rate',
                    'id'    => 'cpr-create-rate',
                    'onchange' => "setv('#cpr-create-price', mul('#cpr-create-amount', '#cpr-create-rate'))",
                    'required' => true
                ],
                [
                    'type'  => 'calc',
                    'name'  => 'price',
                    'label' => 'Total Price',
                    'id'    => 'cpr-create-price',
                    'value' => '0.00'
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
                    'type'  => 'date',
                    'name'  => 'date',
                    'label' => 'Date',
                    'required' => true
                ]
            ]
        ],
        'edit'      => [
            'title' => 'Edit Coal Purchase Entry',
            'action_button' => 'Edit',
            'close_button'  => 'Cancel',
            'elms'  => [
                [
                    'type'  => 'varsel',
                    'name'  => 'supplier_id',
                    'label' => 'Coal Supplier',
                    'url'   => '/api/topresults',
                    'model' => 'coalSupplier',
                    'field' => 'name',
                    'required' => true,
                    'fill'  => ['input' => 'supplier.name', 'hidden' => 'supplier.id']
                ],
                [
                    'type'  => 'coal',
                    'name'  => 'amount',
                    'label' => 'Amount of Coal',
                    'required' => true,
                    'id'    => 'cpr-edit-amount',
                    'onchange' => "setv('#cpr-edit-price', mul('#cpr-edit-amount', '#cpr-edit-rate'))",
                    'fill'  => 'amount'
                ],
                [
                    'type'  => 'check',
                    'name'  => 'is_processed',
                    'label' => 'Processed',
                    'required' => true,
                    'fill'  => 'is_processed'
                ],
                [
                    'type'  => 'number',
                    'name'  => 'rate',
                    'label' => 'Price Rate',
                    'id'    => 'cpr-edit-rate',
                    'onchange' => "setv('#cpr-edit-price', mul('#cpr-edit-amount', '#cpr-edit-rate'))",
                    'required' => true,
                    'fill'  => 'rate'
                ],
                [
                    'type'  => 'calc',
                    'name'  => 'price',
                    'label' => 'Total Price',
                    'value' => '0.00',
                    'id'    => 'cpr-create-price',
                    'fill'  => 'price'
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
                    'type'  => 'date',
                    'name'  => 'date',
                    'label' => 'Date',
                    'required' => true,
                    'fill'  => 'date'
                ]
            ]
        ],
        'filter' => [
            'title' => 'Filter Coal Purchase Entries',
            'action_button' => 'Filter',
            'close_button' => 'Cancel',
            'elms' => [
                [
                    'type'  => 'varsel',
                    'name'  => 'supplier_id',
                    'label' => 'Coal Supplier',
                    'url'   => '/api/topresults',
                    'model' => 'coalSupplier',
                    'field' => 'name'
                ],
                [
                    'type'  => 'text',
                    'name'  => 'amount',
                    'label' => 'Amount of Coal'
                ],
                [
                    'type'  => 'check',
                    'name'  => 'is_processed',
                    'label' => 'Processed'
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
                    'type'  => 'varsel',
                    'name'  => 'depot_id',
                    'label' => 'Depot',
                    'url'   => '/api/topresults',
                    'model' => 'depot',
                    'field' => 'name'
                ]
            ]
        ],
        'details' => [
            'title' => 'Coal Purchase Entry Details',
            'action_button' => null,
            'close_button'  => 'Close',
            'elms'  => [
                'Supplier' => [
                    'head'          => ['field' => 'supplier.name', 'type' => 'text'],
                    'Company/Farm'  => ['field' => 'supplier.corpname', 'type' => 'text'],
                    'Phone'         => ['field' => 'supplier.phone', 'type' => 'text'],
                    'Email'         => ['field' => 'supplier.email', 'type' => 'text'],
                    'GSTIN'         => ['field' => 'supplier.gstin', 'type' => 'text'],
                    'Address'       => ['field' => 'supplier.address', 'type' => 'text'],
                    'City'          => ['field' => 'supplier.city', 'type' => 'text'],
                    'State'         => ['field' => 'supplier.state', 'type' => 'text'],
                    'Country'       => ['field' => 'supplier.country', 'type' => 'text'],
                    'Area Pin'      => ['field' => 'supplier.area_pin', 'type' => 'text'],
                    'Other Details' => ['field' => 'supplier.details', 'type' => 'json']
                ],
                'Depot' => [
                    'head'          => ['field' => 'depot.name', 'type' => 'text'],
                    'Incharge'      => ['field' => 'depot.incharge', 'type' => 'text'],
                    'Phone'         => ['field' => 'depot.phone', 'type' => 'text'],
                    'Email'         => ['field' => 'depot.email', 'type' => 'text'],
                    'Address'       => ['field' => 'depot.address', 'type' => 'text'],
                    'City'          => ['field' => 'depot.city', 'type' => 'text'],
                    'State'         => ['field' => 'depot.state', 'type' => 'text'],
                    'Country'       => ['field' => 'depot.country', 'type' => 'text'],
                    'Area Pin'      => ['field' => 'depot.area_pin', 'type' => 'text']
                ],
                'Amount of Coal (tons)' => ['field' => 'amount', 'type' => 'decimal'],
                'Rate'                  => ['field' => 'rate', 'type' => 'decimal'],
                'Price'                 => ['field' => 'price', 'type' => 'decimal'],
                'Processed'             => ['field' => 'is_processed', 'type' => 'bool'],
                'Date'                  => ['field' => 'date', 'type' => 'date']
            ]
        ],
        'delete'    => [
            'title' => 'Delete Coal Purchase Entry',
            'action_button' => 'Delete',
            'close_button'  => 'Cancel',
            'elms'  => [
                [
                    'type' => 'label',
                    'value' => 'Do you really want to delete the Coal Purchase entry?',
                ]
            ]
        ]
    ];
}
