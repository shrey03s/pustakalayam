<?php namespace App\StatsPages;

/**
 * Description of DepotRecord
 *
 * @author rajnish
 */
class Mining 
{
    public $statstitle = "Mining Report";
    public $pageclass = "mining";
    public $pagesection = "report";
    public $stats = [
        [
            'id' => 'topentries',
            'title' => 'Statistics',
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
            ]
        ],
        [
            'id' => 'topentries',
            'title' => 'Entries',
            [
                'type' => 'table',
                'title' => 'Last 10 Entries',
                'id' => 'miningtab',
                'expand' => true,
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
        ]
    ];
}
