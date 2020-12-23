<?php namespace App\Pages;

/**
 * Description of AssetType
 *
 * @author rajnish
 */
class AssetType
{
    public $tabletitle = "Asset Types";
    public $pageclass = "assettypes";
    public $pagesection = "assets";
    public $model = "assetType";
    public $order = 'ASC';
    public $getentries = "/api/entries";
    public $putentry = "/api/putentry";
    public $entrycount = '/api/entriesinfo';
    public $deleteentry = '/api/delete';

    public $tablefields = [
        'Name'  => ['name' => 'text']
    ];
    public $orderfields = [
        'Name'  => ['field' => 'name']
    ];
    public $searchfields = [
        'Name'  => 'name'
    ];
    
    public $modals = [
        'create'    => [
            'title' => 'Create Asset Type',
            'action_button' => 'Create',
            'close_button'  => 'Cancel',
            'elms'  => [
                [
                    'type'  => 'text',
                    'name'  => 'name',
                    'label' => 'Name',
                    'required' => true
                ]
            ]
        ],
        'edit'      => [
            'title' => 'Edit Asset Type',
            'action_button' => 'Edit',
            'close_button'  => 'Cancel',
            'elms'  => [
                [
                    'type'  => 'text',
                    'name'  => 'name',
                    'label' => 'Name',
                    'required' => true,
                    'fill'  => 'name'
                ]
            ]
        ],
        'filter' => [
            'title' => 'Filter Asset Types',
            'action_button' => 'Filter',
            'close_button' => 'Cancel',
            'elms' => [
                [
                    'type'  => 'text',
                    'name' => 'name',
                    'label' => 'Name'
                ]
            ]
        ],
        'details' => [
            'title' => 'Asset Type Details',
            'action_button' => null,
            'close_button'  => 'Close',
            'elms'  => [
                'Name'  => ['field' => 'name', 'type' => 'text']
            ]
        ],
        'delete'    => [
            'title' => 'Delete Asset Type',
            'action_button' => 'Delete',
            'close_button'  => 'Cancel',
            'elms'  => [
                [
                    'type' => 'label',
                    'value' => 'Do you really want to delete the asset type?',
                ]
            ]
        ]
    ];
}
