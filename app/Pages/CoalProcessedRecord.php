<?php namespace App\Pages;

/**
 * Description of CoalProcessedRecord
 *
 * @author rajnish
 */
class CoalProcessedRecord 
{
    public $tabletitle = "Coal Processing Manager";
    public $pageclass = "processed";
    public $pagesection = "utility";
    public $model = "coalProcessed";
    public $order = 'DESC';
    public $getentries = "/api/entries";
    public $putentry = "/api/putentry";
    public $entrycount = '/api/entriesinfo';
    public $deleteentry = '/api/delete';
    
    public $tablefields = [
        'Incoming Depot'        => ['depotin.name' => 'text'],
        'Raw Amount (tons)'     => ['amount_in' => 'decimal'],
        'Outgoing Depot'        => ['depotout.name' => 'text'],
        'Product Amount (tons)' => ['amount_out' => 'decimal'],
        'Expenses'              => ['expensesum' => 'decimal'],
        'Date'                  => ['date' => 'date']
    ];
    public $orderfields = [
        'Date'            => ['field' => 'date', 'selected' => true],
        'Incoming Depot'  => ['field' => 'depotin.name'],
        'Outgoing Depot'  => ['field' => 'depotout.name'],
        'Raw Amount'      => ['field' => 'amount_in'],
        'Product Amount'  => ['field' => 'amount_out'],
        'Expenses'        => ['field' => 'expensesum']
    ];
    public $searchfields = [
        'Incoming Depot'             => 'depotin.name',
        'Incoming Depot Incharge'    => 'depotin.incharge',
        'Incoming Depot City'        => 'depotin.city',
        'Outgoing Depot'             => 'depotout.name',
        'Outgoing Depot Incharge'    => 'depotout.incharge',
        'Outgoing Depot City'        => 'depotout.city',
        'Expenses'                   => 'expenses'
    ];
    
    public $modals = [
        'create'    => [
            'title' => 'Create Coal Processed Entry',
            'action_button' => 'Create',
            'close_button'  => 'Cancel',
            'elms'  => [
                [
                    'type'  => 'varsel',
                    'name'  => 'depotin_id',
                    'label' => 'Incoming Depot',
                    'url'   => '/api/topresults',
                    'model' => 'depot',
                    'field' => 'name',
                    'required' => true
                ],
                [
                    'type'  => 'varsel',
                    'name'  => 'depotout_id',
                    'label' => 'Outgoing Depot',
                    'url'   => '/api/topresults',
                    'model' => 'depot',
                    'field' => 'name',
                    'required' => true
                ],
                [
                    'type'  => 'coal',
                    'name'  => 'amount_in',
                    'label' => 'Amount Raw Coal',
                    'required' => true
                ],
                [
                    'type'  => 'coal',
                    'name'  => 'amount_out',
                    'label' => 'Amount Product Coal',
                    'required' => true
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
            'title' => 'Edit Coal Processed Entry',
            'action_button' => 'Edit',
            'close_button'  => 'Cancel',
            'elms'  => [
                [
                    'type'  => 'varsel',
                    'name'  => 'depotin_id',
                    'label' => 'Incoming Depot',
                    'url'   => '/api/topresults',
                    'model' => 'depot',
                    'field' => 'name',
                    'required' => true,
                    'fill'  => ['input' => 'depotin.name', 'hidden' => 'depotin.id']
                ],
                [
                    'type'  => 'varsel',
                    'name'  => 'depotout_id',
                    'label' => 'Outgoing Depot',
                    'url'   => '/api/topresults',
                    'model' => 'depot',
                    'field' => 'name',
                    'required' => true,
                    'fill'  => ['input' => 'depotout.name', 'hidden' => 'depotout.id']
                ],
                [
                    'type'  => 'coal',
                    'name'  => 'amount_in',
                    'label' => 'Amount Raw Coal',
                    'required' => true,
                    'fill'  => 'amount_in'
                ],
                [
                    'type'  => 'coal',
                    'name'  => 'amount_out',
                    'label' => 'Amount Product Coal',
                    'required' => true,
                    'fill'  => 'amount_out'
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
            'title' => 'Filter Coal Processed Entries',
            'action_button' => 'Filter',
            'close_button' => 'Cancel',
            'elms' => [
                [
                    'type'  => 'varsel',
                    'name'  => 'depotin_id',
                    'label' => 'Incoming Depot',
                    'url'   => '/api/topresults',
                    'model' => 'depot',
                    'field' => 'name'
                ],
                [
                    'type'  => 'varsel',
                    'name'  => 'depotout_id',
                    'label' => 'Outgoing Depot',
                    'url'   => '/api/topresults',
                    'model' => 'depot',
                    'field' => 'name'
                ],
                [
                    'type'  => 'text',
                    'name'  => 'amount_in',
                    'label' => 'Amount Raw Coal'
                ],
                [
                    'type'  => 'text',
                    'name'  => 'amount_out',
                    'label' => 'Amount Product Coal'
                ],
                [
                    'type'  => 'text',
                    'name'  => 'expensesum',
                    'label' => 'Expenses'
                ],
            ]
        ],
        'details' => [
            'title' => 'Coal Proccessed Entry Details',
            'action_button' => null,
            'close_button'  => 'Close',
            'elms'  => [
                'Depot In' => [
                    'head'      => ['field' => 'depotin.name', 'type' => 'text'],
                    'Incharge'  => ['field' => 'depotin.incharge', 'type' => 'text'],
                    'Phone'     => ['field' => 'depotin.phone', 'type' => 'text'],
                    'Email'     => ['field' => 'depotin.email', 'type' => 'text'],
                    'Address'   => ['field' => 'depotin.address', 'type' => 'text'],
                    'City'      => ['field' => 'depotin.city', 'type' => 'text'],
                    'State'     => ['field' => 'depotin.state', 'type' => 'text'],
                    'Country'   => ['field' => 'depotin.country', 'type' => 'text'],
                    'Area Pin'  => ['field' => 'depotin.area_pin', 'type' => 'text']
                ],
                'Depot Out' => [
                    'head'      => ['field' => 'depotout.name', 'type' => 'text'],
                    'Incharge'  => ['field' => 'depotout.incharge', 'type' => 'text'],
                    'Phone'     => ['field' => 'depotout.phone', 'type' => 'text'],
                    'Email'     => ['field' => 'depotout.email', 'type' => 'text'],
                    'Address'   => ['field' => 'depotout.address', 'type' => 'text'],
                    'City'      => ['field' => 'depotout.city', 'type' => 'text'],
                    'State'     => ['field' => 'depotout.state', 'type' => 'text'],
                    'Country'   => ['field' => 'depotout.country', 'type' => 'text'],
                    'Area Pin'  => ['field' => 'depotout.area_pin', 'type' => 'text']
                ],
                'Amount of raw Coal (tons)'         => ['field' => 'amount_in', 'type' => 'decimal'],
                'Amount of processed Coal (tons)'   => ['field' => 'amount_out', 'type' => 'decimal'],
                'Expenses'                          => ['field' => 'expensesum', 'type' => 'decimal'],
                'Expenses Details'                  => ['field' => 'expenses', 'type' => 'json'],
                'Date'                              => ['field' => 'date', 'type' => 'date']
            ]
        ],
        'delete'    => [
            'title' => 'Delete Coal Processed Entry',
            'action_button' => 'Delete',
            'close_button'  => 'Cancel',
            'elms'  => [
                [
                    'type' => 'label',
                    'value' => 'Do you really want to delete the Coal Processed entry?',
                ]
            ]
        ]
    ];
}
