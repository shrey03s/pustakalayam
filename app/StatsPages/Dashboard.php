<?php namespace App\StatsPages;

/**
 * Description of DepotRecord
 *
 * @author rajnish
 */
class Dashboard 
{
    public $statstitle = "Depot Report";
    public $pageclass = "dashboard";
    public $pagesection = "";
    public $stats = [
        [
            'id' => 'net',
            'title' => 'Net Statistics',
            [
                'type' => 'graph',
                'id' => 'net_income_expenses_price',
                'title' => 'Income and Expenses',
                'data' => [
                    [
                        'label' => 'Income',
                        'api' => '/api/totalstats',
                        'model' => '',
                        'field' => 'income'
                    ],
                    [
                        'label' => 'Expenses',
                        'api' => '/api/totalstats',
                        'model' => '',
                        'field' => 'expenses'
                    ]
                ]
            ],
            
            [
                'type' => 'graph',
                'id' => 'net_profit_price',
                'title' => 'Profit',
                'data' => [
                    [
                        'label' => 'Profit',
                        'api' => '/api/totalstats',
                        'model' => '',
                        'field' => 'profit'
                    ]
                ]
            ],
            
            [
                'type' => 'graph',
                'id' => 'net_raw_in',
                'title' => 'Raw Coal',
                'data' => [
                    [
                        'label' => 'In',
                        'api' => '/api/totalstats',
                        'model' => '',
                        'field' => 'rawin'
                    ],
                    [
                        'label' => 'Out',
                        'api' => '/api/totalstats',
                        'model' => '',
                        'field' => 'rawout'
                    ]
                ]
            ],
            
            [
                'type' => 'graph',
                'id' => 'net_cook_in',
                'title' => 'Cook Coal',
                'data' => [
                    [
                        'label' => 'In',
                        'api' => '/api/totalstats',
                        'model' => '',
                        'field' => 'cookin'
                    ],
                    [
                        'label' => 'Out',
                        'api' => '/api/totalstats',
                        'model' => '',
                        'field' => 'cookout'
                    ]
                ]
            ],
        ],
        [
            'id' => 'depots',
            'title' => 'Depots',
            [
                'type' => 'bar',
                'title' => 'Coal in Depots',
                'expand' => true,
                'data' => [
                    'api' => '/api/totalcoals',
                    'show' => [
                        'raw' => 'Raw Amount(Tons)', 'cook' => 'Cooked Amount(Tons)'
                    ]
                ]
            ],
            [
                'type' => 'bar',
                'title' => 'name',
                'data' => [
                    'api' => '/api/depots',
                    'show' => [
                        'rawamt' => 'Raw Amount(Tons)', 'cookamt' => 'Cooked Amount(Tons)'
                    ]
                ]
            ],
        ],
        [
            'id' => 'minings',
            'title' => 'Mining',
            [
                'type' => 'graph',
                'id' => 'mine_amount',
                'title' => 'Amount of coal from Mining',
                'data' => [
                    [
                        'label' => 'Amount',
                        'api' => '/api/laststats',
                        'model' => 'mining',
                        'field' => 'amount'
                    ]
                ]
            ],
            [
                'type' => 'table',
                'title' => 'Last 10 Entries',
                'id' => 'miningtab',
                'api' => '/api/entries',
                'model' => 'mining',
                'thead' => ['Vehicle', 'Mine', 'Depot', 'Amount (tons)', 'Rate', 'Price', 'Expenses', 'Gross','Date'],
                'filters' => [],
                'fields' => [
                    'vehicle.vin' => 'text',
                    'mine.name' => 'text',
                    'depot.name' => 'text',
                    'amount' => 'decimal',
                    'rate' => 'decimal',
                    'price' => 'decimal',
                    'expensesum' => 'decimal',
                    'gross' => 'decimal',
                    'date' => 'date'
                ]
            ]
        ],
        [
            'id' => 'coal_purchased',
            'title' => 'Coal Purchased',
            [
                'type' => 'graph',
                'id' => 'rawcoal_amount_purchase',
                'title' => 'Amount of Coal Purchased',
                'data' => [
                    [
                        'label' => 'Raw Coal',
                        'api' => '/api/laststats',
                        'model' => 'coalPurchased',
                        'field' => 'rawamt'
                    ],
                    [
                        'label' => 'Cooked Coal',
                        'api' => '/api/laststats',
                        'model' => 'coalPurchased',
                        'field' => 'cookamt'
                    ]
                ]
            ],
            [
                'type' => 'table',
                'title' => 'Last 10 Prurchased Entries',
                'id' => 'purchasedtab',
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
            ]
        ],
        [
            'id' => 'coal_sold',
            'title' => 'Coal Sold',
            [
                'type' => 'graph',
                'id' => 'rawcoal_amount_sold',
                'title' => 'Amount of Coal Sold',
                'data' => [
                    [
                        'label' => 'Raw Coal',
                        'api' => '/api/laststats',
                        'model' => 'coalSold',
                        'field' => 'rawamt'
                    ],
                    [
                        'label' => 'Cooked Coal',
                        'api' => '/api/laststats',
                        'model' => 'coalSold',
                        'field' => 'cookamt'
                    ]
                ]
            ],
            [
                'type' => 'table',
                'title' => 'Last 10 Sold Entries',
                'id' => 'soldtab',
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
        ],
        [
            'id' => 'coal_processed',
            'title' => 'Coal Processed',
            [
                'type' => 'graph',
                'id' => 'coal_processed',
                'title' => 'Amount of Coal Processed',
                'data' => [
                    [
                        'label' => 'Amount Processed',
                        'api' => '/api/laststats',
                        'model' => 'coalProcessed',
                        'field' => 'amount_in'
                    ],
                    [
                        'label' => 'Amount Produced',
                        'api' => '/api/laststats',
                        'model' => 'coalProcessed',
                        'field' => 'amount_out'
                    ]
                ]
            ],
            [
                'type' => 'table',
                'title' => 'Last 10 Processed Entries',
                'id' => 'processedtab',
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
        ],
        [
            'id' => 'rent',
            'title' => 'Rent',
            [
                'type' => 'graph',
                'id' => 'rent_price',
                'title' => 'Rent',
                'data' => [
                    [
                        'label' => 'Rent Paid',
                        'api' => '/api/laststats',
                        'model' => 'rent',
                        'field' => 'income'
                    ]
                ]
            ],
            [
                'type' => 'table',
                'title' => 'Last 10 Unpaid Entries',
                'id' => 'renttab',
                'api' => '/api/entries',
                'model' => 'rent',
                'thead' => ['Vehicle', 'Renter', 'Price Rate', 'Fuel Cost', 'Driver Wages', 'Days Excluded', 'Total Price', 'Dues', 'Paid', 'By Coal', 'Returned', 'Date Returned', 'Date'],
                'filters' => [ 'paid' => false ],
                'fields' => [
                    'vehicle.vin' => 'text',
                    'renter.name' => 'text',
                    'daily_price' => 'decimal',
                    'cost_fuel' => 'decimal',
                    'driver_wages' => 'decimal',
                    'days_ex' => 'number',
                    'netamt' => 'decimal',
                    'remainamt' => 'decimal',
                    'paid' => 'bool',
                    'bycoal' => 'bool',
                    'returned' => 'bool',
                    'date_return' => 'date',
                    'date' => 'date'
                ]
            ]
        ]
    ];
}
