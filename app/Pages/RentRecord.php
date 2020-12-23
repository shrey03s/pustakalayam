<?php namespace App\Pages;

/**
 * Description of RentRecord
 *
 * @author rajnish
 */
class RentRecord 
{
    public $tabletitle = "Vehicle Rent Manager";
    public $pageclass = "rent";
    public $pagesection = "rent";
    public $model = "rent";
    public $order = 'DESC';
    public $getentries = "/api/entries";
    public $putentry = "/api/putrententry";
    public $entrycount = '/api/entriesinfo';
    public $deleteentry = '/api/delete';
    
    public $tablefields = [
        'Vehicle'       => ['vehicle.vin' => 'text'],
        'Renter'        => ['renter.name' => 'text'],
        'Price Rate'    => ['daily_price' => 'decimal'],
        'Fuel Cost'     => ['cost_fuel' => 'decimal'],
        'Driver Wages'  => ['driver_wages' => 'decimal'],
        'Days Excluded' => ['days_ex' => 'number'],
        'Total Price'   => ['netamt' => 'decimal'],
        'Dues'          => ['remainamt' => 'decimal'],
        'Paid'          => ['paid' => 'bool'],
        'By Coal'       => ['bycoal' => 'bool'],
        'Returned'      => ['returned' => 'bool'],
        'Date Returned' => ['date_return' => 'date'],
        'Date'          => ['date' => 'date']
    ];
    public $orderfields = [
        'Date'          => ['field' => 'date', 'selected' => true],
        'Vehicle'       => ['field' => 'vehicle.vin'],
        'Renter'        => ['field' => 'renter.name'],
        'Price Rate'    => ['field' => 'daily_price'],
        'Fuel Cost'     => ['field' => 'cost_fuel'],
        'Driver Wages'  => ['field' => 'driver_wages'],
        'Days Excluded' => ['field' => 'days_ex'],
        'Total Price'   => ['field' => 'netamt'],
        'Paid'          => ['field' => 'paid'],
        'By Coal'       => ['field' => 'bycoal'],
        'Returned'      => ['field' => 'returned'],
        'Date Returned' => ['field' => 'date_return']
    ];
    public $searchfields = [
        'Vehicle VIN'       => 'vehicle.vin',
        'Vehicle Type'      => 'vehicle.type',
        'Renter'            => 'renter.name',
        'Renter City'       => 'renter.city',
        'Renter State'      => 'renter.state',
        'Renter Phone'      => 'renter.phone',
        'Renter Email'      => 'renter.email',
        'Renter Profession' => 'renter.gstin',
        'Renter Details'    => 'renter.details',
        'Returned'          => 'returned',
        'Not Returned'      => '!returned',
        'Paid'              => 'paid',
        'Not Paid'          => '!paid',
        'By Coal'           => 'bycoal',
        'Returned'          => 'returned',
        'Not Returned'      => '!returned'
    ];
    public $modals = [
        'create'    => [
            'title' => 'Create Vehicle Rent Entry',
            'action_button' => 'Create',
            'close_button'  => 'Cancel',
            'elms'  => [
                [
                    'type'  => 'varsel',
                    'name'  => 'vehicle_id',
                    'label' => 'Vehicle',
                    'url'   => '/api/topresults',
                    'model' => 'vehicles',
                    'field' => 'vin',
                    'required' => true
                ],
                [
                    'type'  => 'varsel',
                    'name'  => 'renter_id',
                    'label' => 'Vehicle Renter',
                    'url'   => '/api/topresults',
                    'model' => 'renter',
                    'field' => 'name',
                    'required' => true
                ],
                [
                    'type'  => 'number',
                    'name'  => 'daily_price',
                    'label' => 'Price Rate (per day)',
                    'required' => true,
                    'id'    => 'rent-create-price',
                    'onchange' => "setv('#rent-create-net', mul(sum(sum('#rent-create-fuel', '#rent-create-price'), '#rent-create-driver'), "
                    . "sub(datediff('#rent-create-date-return','#rent-create-date'), '#rent-create-daysex')));"
                    . "setv('#rent-create-amtdue', sub('#rent-create-net','#rent-create-paidamt'))"
                ],
                [
                    'type'  => 'number',
                    'name'  => 'cost_fuel',
                    'label' => 'Fuel Cost',
                    'id'    => 'rent-create-fuel',
                    'onchange' => "setv('#rent-create-net', mul(sum(sum('#rent-create-fuel', '#rent-create-price'), '#rent-create-driver'), "
                    . "sub(datediff('#rent-create-date-return','#rent-create-date'), '#rent-create-daysex')));"
                    . "setv('#rent-create-amtdue', sub('#rent-create-net','#rent-create-paidamt'))"
                ],
                [
                    'type'  => 'number',
                    'name'  => 'driver_wages',
                    'label' => 'Driver Wages',
                    'id'    => 'rent-create-driver',
                    'onchange' => "setv('#rent-create-net', mul(sum(sum('#rent-create-fuel', '#rent-create-price'), '#rent-create-driver'), "
                    . "sub(datediff('#rent-create-date-return','#rent-create-date'), '#rent-create-daysex')));"
                    . "setv('#rent-create-amtdue', sub('#rent-create-net','#rent-create-paidamt'))"
                ],
                [
                    'type'  => 'number',
                    'name'  => 'days_ex',
                    'label' => 'Days Excluded (Negotiations)',
                    'id'    => 'rent-create-daysex',
                    'onchange' => "setv('#rent-create-net', mul(sum(sum('#rent-create-fuel', '#rent-create-price'), '#rent-create-driver'), "
                    . "sub(datediff('#rent-create-date-return','#rent-create-date'), '#rent-create-daysex')));"
                    . "setv('#rent-create-amtdue', sub('#rent-create-net','#rent-create-paidamt'))"
                ],
                [
                    'type'  => 'calc',
                    'name'  => 'netamt',
                    'label' => 'Net Amount',
                    'value' => '0.00',
                    'id'    => 'rent-create-net'
                ],
                [
                    'type'  => 'date',
                    'name'  => 'date',
                    'label' => 'Date',
                    'required' => true,
                    'id'    => 'rent-create-date',
                    'onchange' => "setv('#rent-create-net', mul(sum(sum('#rent-create-fuel', '#rent-create-price'), '#rent-create-driver'), "
                    . "sub(datediff('#rent-create-date-return','#rent-create-date'), '#rent-create-daysex')));"
                    . "setv('#rent-create-amtdue', sub('#rent-create-net','#rent-create-paidamt'))"
                ],
                [
                    'type'  => 'date',
                    'name'  => 'date_return',
                    'label' => 'Date of Return (update later)',
                    'filldate' => false,
                    'id'    => 'rent-create-date-return',
                    'onchange' => "setv('#rent-create-net', mul(sum(sum('#rent-create-fuel', '#rent-create-price'), '#rent-create-driver'), "
                    . "sub(datediff('#rent-create-date-return','#rent-create-date'), '#rent-create-daysex')));"
                    . "setv('#rent-create-amtdue', sub('#rent-create-net','#rent-create-paidamt'))"
                ],
                [
                    'type'  => 'calc',
                    'name'  => 'remainamt',
                    'label' => 'Amount Due',
                    'value' => '0.00',
                    'id'    => 'rent-create-amtdue'
                ],
                [
                    'type'  => 'number',
                    'name'  => 'paidamt',
                    'label' => 'Amount Paid',
                    'id'    => 'rent-create-paidamt',
                    'onchange' => "setv('#rent-create-amtdue', sub('#rent-create-net','#rent-create-paidamt'))"
                ],
                [
                    'type'  => 'number',
                    'label' => 'Add Payment',
                    'id'    => 'rent-create-addpay',
                    'onchange' => "setv('#rent-create-paidamt', sum('#rent-create-paidamt','#rent-create-addpay'));"
                    . "setv('#rent-create-amtdue', sub('#rent-create-net','#rent-create-paidamt'))"
                ],
                [
                    'type'  => 'check',
                    'name'  => 'bycoal',
                    'label' => 'Paid By Coal',
                    'id'    => 'rent-create-cpr-check',
                    'onchange' => "toogleDisable(['#rent-create-cpr-amount', '#rent-create-cpr-amount-input','#rent-create-cpr-amount-select',"
                    . "'#rent-create-cpr-processed','#rent-create-cpr-rate','#rent-create-cpr-depot','#rent-create-cpr-depot-input']);"
                    . "setv('#rent-create-paidamt', ifchd('#rent-create-cpr-check',sum('#rent-create-paidamt','#rent-create-cpr-price'), "
                    . "sub('#rent-create-paidamt','#rent-create-cpr-price')));"
                    . "setv('#rent-create-amtdue', sub('#rent-create-net','#rent-create-paidamt'));"
                ],
                [
                    'type'  => 'number',
                    'name'  => 'cpr_rate',
                    'label' => 'Coal Price Rate',
                    'required' => true,
                    'id'    => 'rent-create-cpr-rate',
                    'onchange' => "setv('#rent-create-cpr-amount', div('#rent-create-amtdue','#rent-create-cpr-rate'));"
                    . "setv('#rent-create-cpr-amount-input', div('#rent-create-amtdue','#rent-create-cpr-rate'));"
                    . "setv('#rent-create-cpr-price', mul('#rent-create-cpr-amount', '#rent-create-cpr-rate'));"
                    . "setv('#rent-create-paidamt', ifchd('#rent-create-cpr-check',sum('#rent-create-paidamt','#rent-create-cpr-price'), '#rent-create-paidamt'));"
                    . "setv('#rent-create-amtdue', sub('#rent-create-net','#rent-create-paidamt'))",
                    'disabled' => true
                ],
                [
                    'type'  => 'coal',
                    'name'  => 'cpr_amount',
                    'label' => 'Amount of Coal',
                    'required' => true,
                    'id'    => 'rent-create-cpr-amount',
                    'onchange' => "setv('#rent-create-cpr-price', mul('#rent-create-cpr-amount', '#rent-create-cpr-rate'));"
                    . "setv('#rent-create-paidamt', ifchd('#rent-create-cpr-check',sum('#rent-create-paidamt','#rent-create-cpr-price'), '#rent-create-paidamt'));"
                    . "setv('#rent-create-amtdue', sub('#rent-create-net','#rent-create-paidamt'))",
                    'disabled' => true
                ],
                [
                    'type'  => 'check',
                    'name'  => 'cpr_is_processed',
                    'label' => 'Processed',
                    'id'    => 'rent-create-cpr-processed',
                    'disabled' => true
                ],
                
                [
                    'type'  => 'varsel',
                    'name'  => 'cpr_depot_id',
                    'label' => 'Depot',
                    'url'   => '/api/topresults',
                    'model' => 'depot',
                    'field' => 'name',
                    'required' => true,
                    'id'    => 'rent-create-cpr-depot',
                    'disabled' => true
                ],
                [
                    'type'  => 'calc',
                    'name'  => 'cpr_price',
                    'label' => 'Coal Total Price',
                    'id'    => 'rent-create-cpr-price',
                    'value' => '0.00'
                ]
            ]
        ],
        'edit'      => [
            'title' => 'Edit Vehicle Rent Entry',
            'action_button' => 'Edit',
            'close_button'  => 'Cancel',
            'elms'  => [
                [
                    'type'  => 'varsel',
                    'name'  => 'vehicle_id',
                    'label' => 'Vehicle',
                    'url'   => '/api/topresults',
                    'model' => 'vehicles',
                    'field' => 'vin',
                    'required' => true,
                    'fill'  => ['input' => 'vehicle.vin', 'hidden' => 'vehicle.id']
                ],
                [
                    'type'  => 'varsel',
                    'name'  => 'renter_id',
                    'label' => 'Vehicle Renter',
                    'url'   => '/api/topresults',
                    'model' => 'renter',
                    'field' => 'name',
                    'required' => true,
                    'fill'  => ['input' => 'renter.name', 'hidden' => 'renter.id']
                ],
                [
                    'type'  => 'number',
                    'name'  => 'daily_price',
                    'label' => 'Price Rate (per day)',
                    'required' => true,
                    'id'    => 'rent-edit-price',
                    'onchange' => "setv('#rent-edit-net', mul(sum(sum('#rent-edit-fuel', '#rent-edit-price'), '#rent-edit-driver'), "
                    . "sub(datediff('#rent-edit-date-return','#rent-edit-date'), '#rent-edit-daysex')));"
                    . "setv('#rent-edit-amtdue', sub('#rent-edit-net','#rent-edit-paidamt'))",
                    'fill'  => 'daily_price'
                ],
                [
                    'type'  => 'number',
                    'name'  => 'cost_fuel',
                    'label' => 'Fuel Cost',
                    'id'    => 'rent-edit-fuel',
                    'onchange' => "setv('#rent-edit-net', mul(sum(sum('#rent-edit-fuel', '#rent-edit-price'), '#rent-edit-driver'), "
                    . "sub(datediff('#rent-edit-date-return','#rent-edit-date'), '#rent-edit-daysex')));"
                    . "setv('#rent-edit-amtdue', sub('#rent-edit-net','#rent-edit-paidamt'))",
                    'fill'  => 'cost_fuel'
                ],
                [
                    'type'  => 'number',
                    'name'  => 'driver_wages',
                    'label' => 'Driver Wages',
                    'id'    => 'rent-edit-driver',
                    'onchange' => "setv('#rent-edit-net', mul(sum(sum('#rent-edit-fuel', '#rent-edit-price'), '#rent-edit-driver'), "
                    . "sub(datediff('#rent-edit-date-return','#rent-edit-date'), '#rent-edit-daysex')));"
                    . "setv('#rent-edit-amtdue', sub('#rent-edit-net','#rent-edit-paidamt'))",
                    'fill'  => 'driver_wages'
                ],
                [
                    'type'  => 'number',
                    'name'  => 'days_ex',
                    'label' => 'Days Excluded (Negotiations)',
                    'id'    => 'rent-edit-daysex',
                    'onchange' => "setv('#rent-edit-net', mul(sum(sum('#rent-edit-fuel', '#rent-edit-price'), '#rent-edit-driver'), "
                    . "sub(datediff('#rent-edit-date-return','#rent-edit-date'), '#rent-edit-daysex')));"
                    . "setv('#rent-edit-amtdue', sub('#rent-edit-net','#rent-edit-paidamt'))",
                    'fill'  => 'days_ex'
                ],
                [
                    'type'  => 'calc',
                    'name'  => 'netamt',
                    'label' => 'Net Amount',
                    'value' => '0.00',
                    'id'    => 'rent-edit-net',
                    'fill'  => 'netamt'
                ],
                [
                    'type'  => 'date',
                    'name'  => 'date',
                    'label' => 'Date',
                    'required' => true,
                    'id'    => 'rent-edit-date',
                    'onchange' => "setv('#rent-edit-net', mul(sum(sum('#rent-edit-fuel', '#rent-edit-price'), '#rent-edit-driver'), "
                    . "sub(datediff('#rent-edit-date-return','#rent-edit-date'), '#rent-edit-daysex')));"
                    . "setv('#rent-edit-amtdue', sub('#rent-edit-net','#rent-edit-paidamt'))",
                    'fill'  => 'date'
                ],
                [
                    'type'  => 'date',
                    'name'  => 'date_return',
                    'label' => 'Date of Return (update later)',
                    'filldate' => false,
                    'id'    => 'rent-edit-date-return',
                    'onchange' => "setv('#rent-edit-net', mul(sum(sum('#rent-edit-fuel', '#rent-edit-price'), '#rent-edit-driver'), "
                    . "sub(datediff('#rent-edit-date-return','#rent-edit-date'), '#rent-edit-daysex')));"
                    . "setv('#rent-edit-amtdue', sub('#rent-edit-net','#rent-edit-paidamt'))",
                    'fill'  => 'date_return'
                ],
                [
                    'type'  => 'calc',
                    'name'  => 'remainamt',
                    'label' => 'Amount Due',
                    'value' => '0.00',
                    'id'    => 'rent-edit-amtdue',
                    'fill'  => 'remainamt'
                ],
                [
                    'type'  => 'number',
                    'name'  => 'paidamt',
                    'label' => 'Amount Paid',
                    'id'    => 'rent-edit-paidamt',
                    'value' => '0.00',
                    'onchange' => "setv('#rent-edit-amtdue', sub('#rent-edit-net','#rent-edit-paidamt'))",
                    'fill'  => 'paidamt'
                ],
                [
                    'type'  => 'number',
                    'label' => 'Add Payment',
                    'id'    => 'rent-edit-addpay',
                    'onchange' => "setv('#rent-edit-paidamt', sum('#rent-edit-paidamt','#rent-edit-addpay'));"
                    . "setv('#rent-edit-amtdue', sub('#rent-edit-net','#rent-edit-paidamt'))"
                ],
                [
                    'type'  => 'check',
                    'name'  => 'bycoal',
                    'label' => 'Paid By Coal',
                    'id'    => 'rent-edit-cpr-check',
                    'onchange' => "setv('#rent-edit-paidamt', ifchd('#rent-edit-cpr-check',sum('#rent-edit-paidamt','#rent-edit-cpr-price'), "
                    . "sub('#rent-edit-paidamt','#rent-edit-cpr-price')));"
                    . "setv('#rent-edit-amtdue', sub('#rent-edit-net','#rent-edit-paidamt'))",
                    'fill'  => 'bycoal'
                ],
                [
                    'type'  => 'number',
                    'name'  => 'cpr_rate',
                    'label' => 'Coal Price Rate',
                    'required' => true,
                    'id'    => 'rent-edit-cpr-rate',
                    'onchange' => "setv('#rent-edit-cpr-amount', div('#rent-edit-amtdue','#rent-edit-cpr-rate'));"
                    . "setv('#rent-edit-cpr-amount-input', div('#rent-edit-amtdue','#rent-edit-cpr-rate'));"
                    . "setv('#rent-edit-cpr-price', mul('#rent-edit-cpr-amount', '#rent-edit-cpr-rate'));"
                    . "setv('#rent-edit-paidamt', ifchd('#rent-edit-cpr-check',sum('#rent-edit-paidamt','#rent-edit-cpr-price'), '#rent-edit-paidamt'));"
                    . "setv('#rent-edit-amtdue', sub('#rent-edit-net','#rent-edit-paidamt'))",
                    'fill'  => 'cpr.rate'
                ],
                [
                    'type'  => 'coal',
                    'name'  => 'cpr_amount',
                    'label' => 'Amount of Coal',
                    'required' => true,
                    'id'    => 'rent-edit-cpr-amount',
                    'onchange' => "setv('#rent-edit-cpr-price', mul('#rent-edit-cpr-amount', '#rent-edit-cpr-rate'));"
                    . "setv('#rent-edit-paidamt', ifchd('#rent-edit-cpr-check',sum('#rent-edit-paidamt','#rent-edit-cpr-price'), '#rent-edit-paidamt'));"
                    . "setv('#rent-edit-amtdue', sub('#rent-edit-net','#rent-edit-paidamt'))",
                    'fill'  => 'cpr.amount'
                ],
                [
                    'type'  => 'check',
                    'name'  => 'cpr_is_processed',
                    'label' => 'Processed',
                    'id'    => 'rent-edit-cpr-processed',
                    'fill'  => 'cpr.is_processed',
                ],
                
                [
                    'type'  => 'varsel',
                    'name'  => 'cpr_depot_id',
                    'label' => 'Depot',
                    'url'   => '/api/topresults',
                    'model' => 'depot',
                    'field' => 'name',
                    'required' => true,
                    'id'    => 'rent-edit-cpr-depot',
                    'fill'  => ['input' => 'cpr.depot.name', 'hidden' => 'cpr.depot.id']
                ],
                [
                    'type'  => 'calc',
                    'name'  => 'cpr_price',
                    'label' => 'Coal Total Price',
                    'id'    => 'rent-edit-cpr-price',
                    'value' => '0.00',
                    'fill'  => 'cpr.price'
                ]
            ]
        ],
        'filter' => [
            'title' => 'Filter Rent Entries',
            'action_button' => 'Filter',
            'close_button' => 'Cancel',
            'elms' => [
                [
                    'type'  => 'varsel',
                    'name'  => 'vehicle_id',
                    'label' => 'Vehicle',
                    'url'   => '/api/topresults',
                    'model' => 'vehicles',
                    'field' => 'vin'
                ],
                [
                    'type'  => 'varsel',
                    'name'  => 'renter_id',
                    'label' => 'Vehicle Renter',
                    'url'   => '/api/topresults',
                    'model' => 'renter',
                    'field' => 'name'
                ],
                [
                    'type'  => 'text',
                    'name'  => 'daily_price',
                    'label' => 'Price Rate (per day)'
                ],
                [
                    'type'  => 'text',
                    'name'  => 'cost_fuel',
                    'label' => 'Fuel Cost'
                ],
                [
                    'type'  => 'text',
                    'name'  => 'driver_wages',
                    'label' => 'Driver Wages'
                ],
                [
                    'type'  => 'text',
                    'name'  => 'days_ex',
                    'label' => 'Days Excluded (Negotiations)'
                ],
                [
                    'type'  => 'text',
                    'name'  => 'netamt',
                    'label' => 'Net Amount'
                ],
                [
                    'type'  => 'text',
                    'name'  => 'paidamt',
                    'label' => 'Amount Paid'
                ],
                [
                    'type'  => 'text',
                    'name'  => 'remainamt',
                    'label' => 'Amount Due'
                ],
                [
                    'type'  => 'check',
                    'name'  => 'paid',
                    'label' => 'Paid'
                ],
                [
                    'type'  => 'check',
                    'name'  => 'bycoal',
                    'label' => 'bycoal'
                ],
                [
                    'type'  => 'check',
                    'name'  => 'returned',
                    'label' => 'Vehicle Returned'
                ],
                [
                    'type'  => 'date',
                    'name'  => 'date_return',
                    'label' => 'Date of Return'
                ]
            ]
        ],
        'details' => [
            'title' => 'Rent Entry Details',
            'action_button' => null,
            'close_button'  => 'Close',
            'elms'  => [
                'Vehicle' => [
                    'head' => ['field' => 'vehicle.vin', 'type' => 'text'],
                    'Vehicle Identification Number (VIN)' => ['field' => 'vehicle.vin', 'type' => 'text'],
                    'Vehicle Type' => ['field' => 'vehicle.type', 'type' => 'text'],
                    'Vehicle Purchase Date' => ['field' => 'vehicle.date', 'type' => 'date']
                ],
                'Renter' => [
                    'head'          => ['field' => 'renter.name', 'type' => 'text'],
                    'Profession'    => ['field' => 'renter.profession', 'type' => 'text'],
                    'Phone'         => ['field' => 'renter.phone', 'type' => 'text'],
                    'Email'         => ['field' => 'renter.email', 'type' => 'text'],
                    'Address'       => ['field' => 'renter.address', 'type' => 'text'],
                    'City'          => ['field' => 'renter.city', 'type' => 'text'],
                    'State'         => ['field' => 'renter.state', 'type' => 'text'],
                    'Country'       => ['field' => 'renter.country', 'type' => 'text'],
                    'Area Pin'      => ['field' => 'renter.area_pin', 'type' => 'text'],
                    'Other Details' => ['field' => 'renter.area_pin', 'type' => 'json']
                ],
                'Cost of Fuel'      => ['field' => 'cost_fuel', 'type' => 'decimal'],
                'Daily Price'       => ['field' => 'daily_price', 'type' => 'decimal'],
                'Driver Wages'      => ['field' => 'driver_wages', 'type' => 'decimal'],
                'Days Negotiated'   => ['field' => 'days_ex', 'type' => 'number'],
                'Amount paid'       => ['field' => 'paidamt', 'type' => 'decimal'],
                'Amount Due'        => ['field' => 'remainamt', 'type' => 'decimal'],
                'Paid'              => ['field' => 'paid', 'type' => 'bool'],
                'By Coal'           => ['field' => 'bycoal', 'type' => 'bool'],
                'Coal Purchase' => [
                    'head' => ['field' => 'cpr.price', 'type' => 'text'],
                    'Supplier' => [
                        'head'          => ['field' => 'cpr.supplier.name', 'type' => 'text'],
                        'Company/Farm'  => ['field' => 'cpr.supplier.corpname', 'type' => 'text'],
                        'Phone'         => ['field' => 'cpr.supplier.phone', 'type' => 'text'],
                        'Email'         => ['field' => 'cpr.supplier.email', 'type' => 'text'],
                        'GSTIN'         => ['field' => 'cpr.supplier.gstin', 'type' => 'text'],
                        'Address'       => ['field' => 'cpr.supplier.address', 'type' => 'text'],
                        'City'          => ['field' => 'cpr.supplier.city', 'type' => 'text'],
                        'State'         => ['field' => 'cpr.supplier.state', 'type' => 'text'],
                        'Country'       => ['field' => 'cpr.supplier.country', 'type' => 'text'],
                        'Area Pin'      => ['field' => 'cpr.supplier.area_pin', 'type' => 'text'],
                        'Other Details' => ['field' => 'cpr.supplier.details', 'type' => 'json']
                    ],
                    'Depot' => [
                        'head'          => ['field' => 'cpr.depot.name', 'type' => 'text'],
                        'Incharge'      => ['field' => 'cpr.depot.incharge', 'type' => 'text'],
                        'Phone'         => ['field' => 'cpr.depot.phone', 'type' => 'text'],
                        'Email'         => ['field' => 'cpr.depot.email', 'type' => 'text'],
                        'Address'       => ['field' => 'cpr.depot.address', 'type' => 'text'],
                        'City'          => ['field' => 'cpr.depot.city', 'type' => 'text'],
                        'State'         => ['field' => 'cpr.depot.state', 'type' => 'text'],
                        'Country'       => ['field' => 'cpr.depot.country', 'type' => 'text'],
                        'Area Pin'      => ['field' => 'cpr.depot.area_pin', 'type' => 'text']
                    ],
                    'Amount of Coal (tons)' => ['field' => 'cpr.amount', 'type' => 'decimal'],
                    'Rate'                  => ['field' => 'cpr.rate', 'type' => 'decimal'],
                    'Price'                 => ['field' => 'cpr.price', 'type' => 'decimal'],
                    'Processed'             => ['field' => 'cpr.is_processed', 'type' => 'bool'],
                    'Date'                  => ['field' => 'cpr.date', 'type' => 'date']
                ],
                'Date Returned'     => ['field' => 'date_return', 'type' => 'date'],
                'Date'              => ['field' => 'date', 'type' => 'date']
            ]
        ],
        'delete'    => [
            'title' => 'Delete Vehicle Rent Entry',
            'action_button' => 'Delete',
            'close_button'  => 'Cancel',
            'elms'  => [
                [
                    'type' => 'label',
                    'value' => 'Do you really want to delete the Vehicle Rent entry?',
                ]
            ]
        ]
    ];
}
