<?php namespace App\Pages;

/**
 * Description of CoalSoldRecord
 *
 * @author rajnish
 */
class CoalSoldRecord 
{
    public $tabletitle = "Coal Selling Manager";
    public $pageclass = "sold";
    public $pagesection = "utility";
    public $model = "coalSold";
    public $order = 'DESC';
    public $getentries = "/api/entries";
    public $putentry = "/api/putentry";
    public $entrycount = '/api/entriesinfo';
    public $deleteentry = '/api/delete';
    
    public $tablefields = [
        'Customer'          => ['buyer.name' => 'text'],
        'Amount (tons)'     => ['amount' => 'decimal'],
        'Rate'              => ['rate' => 'decimal'],
        'Price'             => ['price' => 'decimal'],
        'Depot'             => ['depot.name' => 'text'],
        'Processed/Raw'     => ['is_processed' => 'bool'],
        'Date'              => ['date' => 'date']
    ];
    public $orderfields = [
        'Date'            => ['field' => 'date', 'selected' => true],
        'Customer'        => ['field' => 'buyer.name'],
        'Depot'           => ['field' => 'depot.name'],
        'Amount'          => ['field' => 'amount'],
        'Rate'            => ['field' => 'rate'],
        'Price'           => ['field' => 'price'],
        'Processed/Raw'   => ['field' => 'is_processed']
    ];
    public $searchfields = [
        'Customer'          => 'buyer.name',
        'Customer City'     => 'buyer.city',
        'Customer State'    => 'buyer.state',
        'Customer Phone'    => 'buyer.phone',
        'Customer Email'    => 'buyer.email',
        'Customer GSTIN'    => 'buyer.gstin',
        'Customer Details'  => 'buyer.details',
        'Depot'             => 'depot.name',
        'Depot Incharge'    => 'depot.incharge',
        'Depot City'        => 'depot.city',
        'Depot State'       => 'depot.state',
        'Processed'         => 'is_processed',
        'Raw'               => '!is_processed'
    ];
    
    public $modals = [
        'create'    => [
            'title' => 'Create Coal Sell Entry',
            'action_button' => 'Create',
            'close_button'  => 'Cancel',
            'elms'  => [
                [
                    'type'  => 'varsel',
                    'name'  => 'buyer_id',
                    'label' => 'Coal Customer',
                    'url'   => '/api/topresults',
                    'model' => 'coalCustomer',
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
                    'id'    => 'csr-create-amount',
                    'onchange' => "setv('#csr-create-price', mul('#csr-create-amount','#csr-create-rate'))",
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
                    'id'    => 'csr-create-rate',
                    'onchange' => "setv('#csr-create-price', mul('#csr-create-amount','#csr-create-rate'))",
                    'required' => true
                ],
                [
                    'type'  => 'calc',
                    'name'  => 'price',
                    'label' => 'Total Price',
                    'value' => '0.00',
                    'id'    => 'csr-create-price'
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
            'title' => 'Edit Coal Sell Entry',
            'action_button' => 'Edit',
            'close_button'  => 'Cancel',
            'elms'  => [
                [
                    'type'  => 'varsel',
                    'name'  => 'buyer_id',
                    'label' => 'Coal Customer',
                    'url'   => '/api/topresults',
                    'model' => 'coalCustomer',
                    'field' => 'name',
                    'required' => true,
                    'fill'  => ['input' => 'buyer.name', 'hidden' => 'buyer.id']
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
                    'label' => 'Amount of Coal',
                    'required' => true,
                    'id'    => 'csr-edit-amount',
                    'onchange' => "setv('#csr-edit-price', mul('#csr-edit-amount','#csr-edit-rate'))",
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
                    'id'    => 'csr-edit-rate',
                    'onchange' => "setv('#csr-edit-price', mul('#csr-edit-amount','#csr-edit-rate'))",
                    'required' => true,
                    'fill'  => 'rate'
                ],
                [
                    'type'  => 'calc',
                    'name'  => 'price',
                    'label' => 'Total Price',
                    'value' => '0.00',
                    'id'    => 'csr-create-price',
                    'fill'  => 'price'
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
            'title' => 'Filter Coal Sold Entries',
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
                ]
            ]
        ],
        'details' => [
            'title' => 'Coal Sell Entry Details',
            'action_button' => null,
            'close_button'  => 'Close',
            'elms'  => [
                'Buyer' => [
                    'head'          => ['field' => 'buyer.name', 'type' => 'text'],
                    'Company/Farm'  => ['field' => 'buyer.corpname', 'type' => 'text'],
                    'GSTIN'         => ['field' => 'buyer.gstin', 'type' => 'text'],
                    'Phone'         => ['field' => 'buyer.phone', 'type' => 'text'],
                    'Email'         => ['field' => 'buyer.email', 'type' => 'text'],
                    'Address'       => ['field' => 'buyer.address', 'type' => 'text'],
                    'City'          => ['field' => 'buyer.city', 'type' => 'text'],
                    'State'         => ['field' => 'buyer.state', 'type' => 'text'],
                    'Country'       => ['field' => 'buyer.country', 'type' => 'text'],
                    'Area Pin'      => ['field' => 'buyer.area_pin', 'type' => 'text'],
                    'Other Details' => ['field' => 'buyer.details', 'type' => 'json']
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
            'title' => 'Delete Coal Sell Entry',
            'action_button' => 'Delete',
            'close_button'  => 'Cancel',
            'elms'  => [
                [
                    'type' => 'label',
                    'value' => 'Do you really want to delete the Coal Sell entry?',
                ]
            ]
        ]
    ];
}
