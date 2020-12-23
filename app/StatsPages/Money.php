<?php namespace App\StatsPages;

/**
 * Description of DepotRecord
 *
 * @author rajnish
 */
class Money 
{
    public $statstitle = "Money Report";
    public $pageclass = "money";
    public $pagesection = "report";
    public $stats = [
        [
            'id' => 'net',
            'title' => 'Net Income/Expenses Statistics',
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
        ],
        [
            'id' => 'net',
            'title' => 'Income/Expenses statistics',
            [
                'type' => 'graph',
                'id' => 'mine_price',
                'title' => 'Pice of Coal and Expense from Mining',
                'data' => [
                    [
                        'label' => 'Pice of Coal',
                        'api' => '/api/laststats',
                        'model' => 'mining',
                        'field' => 'price'
                    ],
                    [
                        'label' => 'Expenses',
                        'api' => '/api/laststats',
                        'model' => 'mining',
                        'field' => 'expenses'
                    ]
                ]
            ],
            [
                'type' => 'graph',
                'id' => 'rawcoal_price_purchase',
                'title' => 'Price of Coal Purchased',
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
                'id' => 'rawcoal_price_sold',
                'title' => 'Price of Coal Sold',
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
            [
                'type' => 'graph',
                'id' => 'rent_price',
                'title' => 'Income from Rent',
                'data' => [
                    [
                        'label' => 'Income',
                        'api' => '/api/laststats',
                        'model' => 'rent',
                        'field' => 'income'
                    ]
                ]
            ],
            [
                'type' => 'graph',
                'id' => 'assets_expenses',
                'title' => 'Expenses on Assets',
                'data' => [
                    [
                        'label' => 'Expenses',
                        'api' => '/api/laststats',
                        'model' => 'assets',
                        'field' => 'cost'
                    ]
                ]
            ],
            [
                'type' => 'graph',
                'id' => 'payroll_expenses',
                'title' => 'Expenses on Paying Employees',
                'data' => [
                    [
                        'label' => 'Expenses',
                        'api' => '/api/laststats',
                        'model' => 'payroll',
                        'field' => 'expenses'
                    ]
                ]
            ],
        ]
    ];
}
