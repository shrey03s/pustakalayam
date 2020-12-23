<?php namespace App\StatsPages;

/**
 * Description of DepotRecord
 *
 * @author rajnish
 */
class CoalUtility 
{
    public $statstitle = "Coal Utility";
    public $pageclass = "coal";
    public $pagesection = "report";
    public $stats = [
        [
            'id' => 'coal_purchased',
            'title' => 'Coal Purchased Statistics',
            [
                'type' => 'graph',
                'id' => 'rawcoal_amount_purchase',
                'title' => 'Amount of Raw Coal Purchased',
                'data' => [
                    [
                        'label' => 'Raw Coal',
                        'api' => '/api/laststats',
                        'model' => 'coalPurchased',
                        'field' => 'rawamt'
                    ]
                ]
            ],
            [
                'type' => 'graph',
                'id' => 'cooked_amount_purchase',
                'title' => 'Amount of Cooked Coal Purchased',
                'data' => [
                    [
                        'label' => 'Cooked Coal',
                        'api' => '/api/laststats',
                        'model' => 'coalPurchased',
                        'field' => 'cookamt'
                    ]
                ]
            ],
            [
                'type' => 'graph',
                'id' => 'rawcoal_price_purchase',
                'title' => 'Price of Raw Coal and Cooked Coal Purchased',
                'data' => [
                    [
                        'label' => 'Raw Coal',
                        'api' => '/api/laststats',
                        'model' => 'coalPurchased',
                        'field' => 'rawprice'
                    ],
                    [
                        'label' => 'Cooked Coal',
                        'api' => '/api/laststats',
                        'model' => 'coalPurchased',
                        'field' => 'cookprice'
                    ]
                ]
            ],
            [
                'type' => 'graph',
                'id' => 'cooked_price_purchase',
                'title' => 'Price of Total Coal Purchased',
                'data' => [
                    [
                        'label' => 'Price',
                        'api' => '/api/laststats',
                        'model' => 'coalPurchased',
                        'field' => 'price'
                    ]
                ]
            ],
        ],
        
        [
            'id' => 'coal_sold',
            'title' => 'Coal Sold Statistics',
            [
                'type' => 'graph',
                'id' => 'rawcoal_amount_sold',
                'title' => 'Amount of Raw Coal Sold',
                'data' => [
                    [
                        'label' => 'Raw Coal',
                        'api' => '/api/laststats',
                        'model' => 'coalSold',
                        'field' => 'rawamt'
                    ]
                ]
            ],
            [
                'type' => 'graph',
                'id' => 'cooked_amount_sold',
                'title' => 'Amount of Cooked Coal Sold',
                'data' => [
                    [
                        'label' => 'Cooked Coal',
                        'api' => '/api/laststats',
                        'model' => 'coalSold',
                        'field' => 'cookamt'
                    ]
                ]
            ],
            [
                'type' => 'graph',
                'id' => 'rawcoal_price_sold',
                'title' => 'Price of Raw Coal and Cooked Sold',
                'data' => [
                    [
                        'label' => 'Raw Coal',
                        'api' => '/api/laststats',
                        'model' => 'coalSold',
                        'field' => 'rawprice'
                    ],
                    [
                        'label' => 'Cooked Coal',
                        'api' => '/api/laststats',
                        'model' => 'coalSold',
                        'field' => 'cookprice'
                    ]
                ]
            ],
            [
                'type' => 'graph',
                'id' => 'cooked_price_sold',
                'title' => 'Price of Total Coal Sold',
                'data' => [
                    [
                        'label' => 'Price',
                        'api' => '/api/laststats',
                        'model' => 'coalSold',
                        'field' => 'price'
                    ]
                ]
            ],
        ],
        
        [
            'id' => 'coal_processed',
            'title' => 'Coal Processed Statistics',
            [
                'type' => 'graph',
                'id' => 'coal_processed',
                'title' => 'Amount of Coal Processed',
                'data' => [
                    [
                        'label' => 'Processed',
                        'api' => '/api/laststats',
                        'model' => 'coalProcessed',
                        'field' => 'amount_in'
                    ],
                    [
                        'label' => 'Produced',
                        'api' => '/api/laststats',
                        'model' => 'coalProcessed',
                        'field' => 'amount_out'
                    ]
                ]
            ],
            [
                'type' => 'graph',
                'id' => 'expenses_processed',
                'title' => 'Expenses of Coal Processed',
                'data' => [
                    [
                        'label' => 'Expenses',
                        'api' => '/api/laststats',
                        'model' => 'coalProcessed',
                        'field' => 'expenses'
                    ]
                ]
            ],
        ],
        
        [
            'id' => 'topentries',
            'title' => 'Entries',
            [
                'type' => 'table',
                'title' => 'Last 10 Prurchased Entries',
                'id' => 'purchasedtab',
                'expand' => true,
                'api' => '/api/entries',
                'model' => 'coalPurchased',
                'thead' => ['Supplier', 'Amount (tons)', 'Rate', 'Price', 'Depot', 'Processed/Raw', 'Date'],
                'filters' => [],
                'fields' => [
                    'supplier.name' => 'text',
                    'amount' => 'decimal',
                    'rate' => 'decimal',
                    'price' => 'decimal',
                    'depot.name' => 'text',
                    'is_processed' => 'bool',
                    'date' => 'date'
                ]
            ],
            [
                'type' => 'table',
                'title' => 'Last 10 Sold Entries',
                'id' => 'soldtab',
                'expand' => true,
                'api' => '/api/entries',
                'model' => 'coalSold',
                'thead' => ['Customer', 'Amount (tons)', 'Rate', 'Price', 'Depot', 'Processed/Raw', 'Date'],
                'filters' => [],
                'fields' => [
                    'buyer.name' => 'text',
                    'amount' => 'decimal',
                    'rate' => 'decimal',
                    'price' => 'decimal',
                    'depot.name' => 'text',
                    'is_processed' => 'bool',
                    'date' => 'date'
                ]
            ],
            [
                'type' => 'table',
                'title' => 'Last 10 Processed Entries',
                'id' => 'processedtab',
                'expand' => true,
                'api' => '/api/entries',
                'model' => 'coalProcessed',
                'thead' => ['Incoming Depot', 'Raw Amount (tons)', 'Outgoing Depot', 'Product Amount (tons)', 'Expenses', 'Date'],
                'filters' => [],
                'fields' => [
                    'depotin.name' => 'text',
                    'amount_in' => 'decimal',
                    'depotout.name' => 'text',
                    'amount_out' => 'decimal',
                    'expensesum' => 'decimal',
                    'date' => 'date'
                ]
            ]
        ]
    ];
}
