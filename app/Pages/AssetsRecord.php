<?php namespace App\Pages;

/**
 * Description of AssetsRecord
 *
 * @author rajnish
 */
class AssetsRecord 
{
    public $tabletitle = "Assets Manager";
    public $pageclass = "assets";
    public $pagesection = "assets";
    public $model = "assets";
    public $order = 'DESC';
    public $getentries = "/api/entries";
    public $putentry = "/api/putentry";
    public $entrycount = '/api/entriesinfo';
    public $deleteentry = '/api/delete';

    public $tablefields = [
        'Name'      => ['name' => 'text'],
        'Type'      => ['type.name' => 'text'],
        'New Stock' => ['newstock' => 'bool'],
        'Depot'     => ['depot.name' => 'text'],
        'Quantity'  => ['amount' => 'decimal'],
        'Rate'      => ['cost' => 'decimal'],
        'Cost'      => ['cost' => 'decimal'],
        'Used'      => ['usedamt' => 'decimal'],
        'Stock'     => ['stockamt' => 'decimal'],
        'Date'      => ['date' => 'date']
    ];
    public $orderfields = [
        'Date'      => ['field' => 'date', 'selected' => true],
        'Type'      => ['field' => 'type.name'],
        'Name'      => ['field' => 'name'],
        'Quantity'  => ['field' => 'amount'],
        'Rate'      => ['field' => 'rate'],
        'Cost'      => ['field' => 'cost'],
        'New Stock' => ['field' => 'newstock'],
        'Depot'     => ['field' => 'depot.name'],
        'Used'      => ['field' => 'usedamt'],
        'Stock'     => ['field' => 'stockamt']
    ];
    public $searchfields = [
        'Type'              => 'type.name',
        'Name'              => 'name',
        'New Stock'         => 'newstock',
        'Used'              => '!newstock',
        'Description'       => 'desc',
        'Details'           => 'details',
        'Depot'             => 'depot.name',
        'Depot Incharge'    => 'depot.incharge',
        'Depot City'        => 'depot.city',
        'Depot State'       => 'depot.state'
    ];
    
    public $modals = [
        'create'    => [
            'title' => 'Create Asset',
            'action_button' => 'Create',
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
                    'type'  => 'varsel',
                    'name'  => 'type_id',
                    'label' => 'Type',
                    'url'   => '/api/topresults',
                    'model' => 'assetType',
                    'field' => 'name',
                    'createable' => true,
                    'required' => true
                ],
                [
                    'type'  => 'check',
                    'name'  => 'newstock',
                    'label' => 'New Stock',
                    'value' => 'checked',
                    'id'    => 'asset-create-newstock',
                    'onchange' => "assetNewstockEvents('#asset-create-newstock', '#asset-create-rate', '#asset-create-usedamt',"
                    . "'#asset-create-cost','#asset-create-stockamt','#asset-create-amount')"
                ],
                [
                    'type'  => 'number',
                    'name'  => 'amount',
                    'label' => 'Quantity',
                    'id'    => 'asset-create-amount',
                    'onchange' => "assetAmountEvents('#asset-create-amount', '#asset-create-newstock', '#asset-create-rate', "
                    . "'#asset-create-cost', '#asset-create-usedamt')",
                    'required' => true
                ],
                [
                    'type'  => 'number',
                    'name'  => 'rate',
                    'label' => 'Price Rate',
                    'id'    => 'asset-create-rate',
                    'onchange' => "setv('#asset-create-cost', mul('#asset-create-amount', '#asset-create-rate'))"
                ],
                [
                    'type'  => 'calc',
                    'name'  => 'cost',
                    'label' => 'Total Cost',
                    'id'    => 'asset-create-cost',
                    'value' => '0.00'
                ],
                [
                    'type'  => 'number',
                    'name'  => 'usedamt',
                    'label' => 'Quantity Used',
                    'id'    => 'asset-create-usedamt',
                    'required' => true,
                    'onchange' => "setv('#asset-create-stockamt', sub('#asset-create-amount', '#asset-create-usedamt'))"
                ],
                [
                    'type'  => 'calc',
                    'name'  => 'stockamt',
                    'label' => 'Quantity in Stock',
                    'id'    => 'asset-create-stockamt',
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
                    'type'  => 'textarea',
                    'name'  => 'desc',
                    'label' => 'Description',
                    'value' => '',
                    'placeholder' => 'Some Description'
                ],
                [
                    'type'  => 'table',
                    'name'  => 'details',
                    'label' => 'Details',
                    'th'    => ['Type','Value']
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
            'title' => 'Edit Asset',
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
                    'type'  => 'varsel',
                    'name'  => 'type_id',
                    'label' => 'Type',
                    'url'   => '/api/topresults',
                    'model' => 'assetType',
                    'field' => 'name',
                    'createable' => true,
                    'required' => true,
                    'fill'  => ['input' => 'type.name', 'hidden' => 'type.id']
                ],
                [
                    'type'  => 'check',
                    'name'  => 'newstock',
                    'label' => 'Is New Stock',
                    'value' => 'checked',
                    'id'    => 'asset-edit-newstock',
                    'onchange' => "assetNewstockEvents('#asset-edit-newstock', '#asset-edit-rate', '#asset-edit-usedamt',"
                    . "'#asset-edit-cost','#asset-edit-stockamt','#asset-edit-amount')"
                ],
                [
                    'type'  => 'number',
                    'name'  => 'amount',
                    'label' => 'Quantity',
                    'value' => '',
                    'id'    => 'asset-edit-amount',
                    'onchange' => "assetAmountEvents('#asset-edit-amount', '#asset-edit-newstock', '#asset-edit-rate', "
                    . "'#asset-edit-cost', '#asset-edit-usedamt')",
                    'required' => true,
                    'fill'  => 'amount'
                ],
                [
                    'type'  => 'number',
                    'name'  => 'rate',
                    'label' => 'Price Rate',
                    'value' => '',
                    'id'    => 'asset-edit-rate',
                    'onchange' => "setv('#asset-edit-cost', mul('#asset-edit-amount', '#asset-edit-rate'))",
                    'fill'  => 'rate'
                ],
                [
                    'type'  => 'calc',
                    'name'  => 'cost',
                    'label' => 'Total Cost',
                    'id'    => 'asset-edit-cost',
                    'value' => '0.00',
                    'fill'  => 'cost'
                ],
                [
                    'type'  => 'number',
                    'name'  => 'usedamt',
                    'label' => 'Quantity Used',
                    'value' => '',
                    'id'    => 'asset-edit-usedamt',
                    'required' => true,
                    'onchange' => "setv('#asset-edit-stockamt', sub('#asset-edit-amount', '#asset-edit-usedamt'))",
                    'fill'  => 'usedamt'
                ],
                [
                    'type'  => 'calc',
                    'name'  => 'stockamt',
                    'label' => 'Quantity in Stock',
                    'id'    => 'asset-edit-stockamt',
                    'value' => '0.00',
                    'fill'  => 'stockamt'
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
                    'type'  => 'textarea',
                    'name'  => 'desc',
                    'label' => 'Description',
                    'value' => '',
                    'placeholder' => 'Some Description',
                    'fill'  => 'desc'
                ],
                [
                    'type'  => 'table',
                    'name'  => 'details',
                    'label' => 'Details',
                    'th'    => ['Type','Value'],
                    'fill'  => ['table' => 'details', 'hidden' => 'details']
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
            'title' => 'Filter Assets',
            'action_button' => 'Filter',
            'close_button' => 'Cancel',
            'elms' => [
                [
                    'type'  => 'text',
                    'name' => 'name',
                    'label' => 'Name'
                ],
                [
                    'type'  => 'varsel',
                    'name' => 'type_id',
                    'label' => 'Type',
                    'url'   => '/api/topresults',
                    'model' => 'assetType',
                    'field' => 'name'
                ],
                [
                    'type'  => 'check',
                    'name'  => 'newstock',
                    'label' => 'New Stock',
                    'value' => 'checked'
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
                    'label' => 'Quantity'
                ],
                [
                    'type'  => 'text',
                    'name'  => 'rate',
                    'label' => 'Price Rate'
                ],
                [
                    'type'  => 'text',
                    'name'  => 'cost',
                    'label' => 'Total Price'
                ],
                [
                    'type'  => 'text',
                    'name'  => 'usedamt',
                    'label' => 'Quantity Used'
                ],
                [
                    'type'  => 'text',
                    'name'  => 'stockamt',
                    'label' => 'Quantity in Stock'
                ]
            ]
        ],
        'details' => [
            'title' => 'Asset Entry Details',
            'action_button' => null,
            'close_button'  => 'Close',
            'elms'  => [
                'Name'          => ['field' => 'name', 'type' => 'text'],
                'Type'          => ['field' => 'type.name', 'type' => 'text'],
                'New Stock'     => ['field' => 'in_stock', 'type' => 'bool'],
                'Amount'        => ['field' => 'amount', 'type' => 'decimal'],
                'Rate'          => ['field' => 'rate', 'type' => 'decimal'],
                'Cost'          => ['field' => 'cost', 'type' => 'decimal'],
                'Used'          => ['field' => 'usedamt', 'type' => 'decimal'],
                'Stock'         => ['field' => 'stockamt', 'type' => 'decimal'],
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
                'Details' => ['field' => 'details', 'type' => 'json'],
                'Description'   => ['field' => 'desc', 'type' => 'text'],
                'Date'          => ['field' => 'date', 'type' => 'date']
            ]
        ],
        'delete'    => [
            'title' => 'Delete Asset',
            'action_button' => 'Delete',
            'close_button'  => 'Cancel',
            'elms'  => [
                [
                    'type' => 'label',
                    'value' => 'Do you really want to delete the asset entry?',
                ]
            ]
        ]
    ];
}
