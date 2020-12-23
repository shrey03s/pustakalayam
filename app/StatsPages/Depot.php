<?php namespace App\StatsPages;

/**
 * Description of DepotRecord
 *
 * @author rajnish
 */
class Depot 
{
    public $statstitle = "Depot Report";
    public $pageclass = "depot";
    public $pagesection = "report";
    public $stats = [
        [
            'id' => 'totalcoal',
            'title' => 'Coal In Depots',
            [
                'type' => 'bar',
                'title' => 'Total Coal',
                'expand' => true,
                'data' => [
                    'api' => '/api/totalcoals',
                    'show' => [
                        'raw' => 'Raw Amount', 'cook' => 'Cooked Amount'
                    ]
                ]
            ],
        ],
        [
            'id' => 'coaldepot',
            [
                'type' => 'bar',
                'title' => 'name',
                'data' => [
                    'api' => '/api/depots',
                    'show' => [
                        'rawamt' => 'Raw Amount', 'cookamt' => 'Cooked Amount'
                    ]
                ]
            ],
        ],
        [
            'id' => 'assets',
            'title' => 'Assets in Depots',
            [
                'type' => 'assets',
                'title' => 'Assets',
                'id' => 'assets',
            ],
        ],
    ];
}
