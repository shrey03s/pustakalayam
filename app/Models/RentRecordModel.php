<?php namespace App\Models;

use App\ExtendedModel;

/**
 * Description of RentRecord
 *
 * @author rajnish
 */
class RentRecordModel extends ExtendedModel
{
    protected $table = 'rent_record';
    protected $primaryKey = 'id';
    
    protected $returnType = 'array';
    protected $availableFields =['vehicle_id', 'renter_id', 'cost_fuel', 'daily_price', 'driver_wages', 
        'days_ex', 'netamt', 'date_return', 'paidamt', 'remainamt', 'returned', 'paid', 'bycoal', 'cpr_id', 'date'];
    protected $allowedFields = ['vehicle_id', 'renter_id', 'cost_fuel', 'daily_price', 'driver_wages', 
        'days_ex', 'date_return', 'paidamt', 'cpr_id', 'date'];
    protected $useTimestamps = true;
    protected $useSoftDeletes = false;

    protected $validationRules    = [
        'vehicle_id'    => 'required|greater_than[0]|numeric',
        'renter_id'     => 'required|greater_than[0]|numeric',
        'daily_price'   => 'required|decimal',
        'cost_fuel'     => 'permit_empty|decimal',
        'driver_wages'  => 'permit_empty|decimal',
        'days_ex'       => 'permit_empty|numeric',
        'paidamt'       => 'permit_empty|decimal',
        'date_return'   => 'permit_empty|valid_date',
        'cpr_id'        => 'permit_empty|greater_than[0]|numeric',
        'date'          => 'required|valid_date'
    ];
    protected $validationMessages = [
        'vehicle_id' => [
            'required'      => 'Vehicle is required!',
            'greater_than'  => 'Invalid Vehicle selected!'
        ],
        'renter_id' => [
            'required'      => 'Renter is required!',
            'greater_than'  => 'Invalid Vehicle Renter selected!'
        ],
        'daily_price' => [
            'required'      => 'The daily price rate of the rented vehicle is required!'
        ]
    ];
    protected $skipValidation     = false;
    
    protected $searchJsonFields     = ['vehicle.vin', 'vehicle.type', 'renter.name', 'renter.address', 'renter.city', 'renter.state', 'renter.country',
        'renter.area_pin', 'renter.phone', 'renter.email', 'renter.profession', 'renter.details'];
    protected $searchBooleanFields  = ['returned','paid', 'bycoal'];
    protected $filterDFields        = ['vehicle_id', 'renter_id', 'date_return'];
    protected $filterNFields        = ['returned','paid', 'bycoal', 'cost_fuel','daily_price','driver_wages','days_ex','netamt','paidamt','remainamt'];
    protected $orderJsonFields      = ['vehicle.vin','renter.name'];
    protected $orderTableFields     = ['cost_fuel', 'daily_price', 'driver_wages', 'netamt','paidamt', 'remainamt', 'paid', 'bycoal', 'days_ex', 'date_return', 'date'];
    protected $editableFields = [
        'vehicle_id'    => 'int',
        'renter_id'     => 'int',
        'cost_fuel'     => 'decimal',
        'daily_price'   => 'decimal',
        'driver_wages'  => 'decimal',
        'days_ex'       => 'int',
        'paidamt'       => 'decimal',
        'date_return'   => 'date',
        'cpr_id'        => 'int',
        'date'          => 'date'
    ];
    protected $publicFields = ['paidamt','date_return'];
    protected $foreignFields = [
        'vehicle_id'    => 'VehiclesModel',
        'renter_id'     => 'RentersModel',
        'cpr_id'        => 'CoalPurchasedRecordModel'
    ];
    protected $sumableFields = ['netamt', 'remainamt'];
    
    protected $statFields = [
        'income'    => "paidamt"
    ];
    
    protected $exportFields = [
        'Vehicle'           => ['field' => 'vehicle_id', 'type' => 'foreign', 'table' => 'vehicles', 'tablefield' => 'vin'],
        'Renter'            => ['field' => 'renter_id', 'type' => 'foreign', 'table' => 'renters', 'tablefield' => 'name'],
        'Daily Price'       => ['field' => 'daily_price', 'type' => 'decimal'],
        'Cost Fuel'         => ['field' => 'cost_fuel', 'type' => 'decimal'],
        'Driver Wages'      => ['field' => 'driver_wages', 'type' => 'decimal'],
        'Days Excluded'     => ['field' => 'days_ex', 'type' => 'integer'],
        'Net Amount'        => ['field' => 'netamt', 'type' => 'decimal'],
        'Amount Paid'       => ['field' => 'paidamt', 'type' => 'decimal'],
        'Amount Due'        => ['field' => 'remainamt', 'type' => 'decimal'],
        'Paid'              => ['field' => 'paid', 'type' => 'bool'],
        'By Coal'           => ['field' => 'bycoal', 'type' => 'bool'],
        'Date Returned'     => ['field' => 'date_return', 'type' => 'date'],
        'Date'              => ['field' => 'date', 'type' => 'date']
    ];
    
    protected function baseQueryBuilder() {
        $selsql = "id, (". $this->toJsonQuery('VehiclesModel', 'rent_record.vehicle_id') .") as vehicle,"
                . "(". $this->toJsonQuery('RentersModel', 'rent_record.renter_id') .") as renter,"
                . "cost_fuel,daily_price,driver_wages,days_ex,date_return,netamt,paidamt,remainamt,returned,paid,bycoal,"
                . "(". $this->toJsonQuery('CoalPurchasedRecordModel', 'rent_record.cpr_id') .") as cpr,"
                . ",`date`";
        
        return $this->builder()->select($selsql);
    }
    
    private function saveCoalPurchaseRecord($args, $id=0) {
        $cpr_id = 0;
        
        if ($id!==0 && (!isset($args['cpr_depot_id']) || !isset($args['cpr_amount'])
                || !isset($args['cpr_rate']) || !isset($args['cpr_is_processed']))) {
            return ['request' => "Missing fields for Coal Purchase Entry!" ];
        }
        
        $renter = model('RentersModel')->find($args['renter_id']);
        $suppliermodel = model('CoalSuppliersModel');
        $supplier = $suppliermodel->builder()->where('renter_id', $renter['id'])->get()->getRow();
        $supplier_id = 0;
        if($supplier === null) {
            $res = $suppliermodel->save([
                'name'      => $renter['name'],
                'phone'     => $renter['phone'],
                'email'     => $renter['email'],
                'address'   => $renter['address'],
                'city'      => $renter['city'],
                'state'     => $renter['state'],
                'country'   => $renter['country'],
                'area_pin'  => $renter['area_pin'],
                'renter_id' => $renter['id']
            ]);
            if ($res) {
                $supplier_id = $suppliermodel->getInsertID();
            }
        } else {
            $supplier_id = $supplier->id;
        }

        if ($supplier_id === 0) {
            return ['database' => $suppliermodel->errors()];
        }

        $cprmodel = model('CoalPurchasedRecordModel');
        
        if ($id === 0) {
            $res = $cprmodel->save([
                'supplier_id'   => $supplier_id,
                'depot_id'      => $args['cpr_depot_id'],
                'amount'        => $args['cpr_amount'],
                'rate'          => $args['cpr_rate'],
                'is_processed'  => $args['cpr_is_processed'],
                'date'          => $args['date']
            ]);

            if ($res) {
                $cpr_id = $cprmodel->getInsertID();
            } else {
                return ['database' => $cprmodel->errors()];
            }
        } else {
            $cprec = [
                'id'            => $id,
                'supplier_id'   => $supplier_id
            ];
            
            foreach (['cpr_depot_id','cpr_amount', 'cpr_rate', 'cpr_is_processed'] as $f) {
                if(in_array($f, array_keys($args))) {
                    $cprec[str_replace('cpr_', '', $f)] = $args[$f];
                }
            }
            
            if ($cprmodel->save($cprec)) {
                $cpr_id = $id;
            } else {
                return ['database' => $cprmodel->errors()];
            }
        }
        
        return $cpr_id;
    }
    
    public function saveRentEntry($args, $modifying = false) {
        helper(['auth']);
        $cpr_id = 0;
        
        if ($modifying && !has_permission("app.delete.entry")) {
            $allowed = ['days_ex','date_return','paidamt','bycoal','cpr_depot_id',
                    'cpr_amount','cpr_rate','cpr_is_processed'];
            foreach ($args as $field => $value) {
                if ($field === 'id') {
                    continue;
                }
                if (!in_array($field, $allowed)) {
                    unset($args[$field]);
                }
            }
            if (count($args) < 2) {
                return ['permissions' => 'Permission Denied!'];
            }
        }
        
        foreach ($args as $field => $value) {
            switch ($field) {
                case 'bycoal':
                case 'cpr_is_processed':
                    if (in_array($value, ['on', '1', 'true'])) {
                        $args[$field] = 1;
                    } else {
                        $args[$field] = 0;
                    }
                    break;
                case 'date':
                case 'date_return':
                    if (!empty($value) && strpos($value, '0000-00-00') === false) {
                        $args[$field] = $value;
                    } else {
                        $args[$field] = null;
                    }
                    break;
                default :
                    if (is_string($value) && empty($value)) {
                        $args[$field] = null;
                    }
            }
        }
        
        if (!$modifying && isset($args['bycoal']) && $args['bycoal'] == 1) {
            $cpr_id = $this->saveCoalPurchaseRecord($args);
            if (!is_int($cpr_id)) {
                return $cpr_id;
            }
        } elseif ($modifying && isset($args['bycoal'])) {
            
            $rent = $this->find($args['id']);
            if ($rent['cpr_id'] === null && $args['bycoal'] == 1) {
                $args['renter_id'] = $rent['renter_id'];
                $cpr_id = $this->saveCoalPurchaseRecord($args);
                if (!is_int($cpr_id)) {
                    return $cpr_id;
                }
            } elseif ($rent['cpr_id'] !== null && $args['bycoal'] == 0) {
                $cprmodel = model('CoalPurchasedRecordModel');
                $cprmodel->delete($rent['cpr_id']);
                $cpr_id = 0;
            } else if ($rent['cpr_id'] !== null && $args['bycoal'] == 1) {
                $args['renter_id'] = $rent['renter_id'];
                $cpr_id = $this->saveCoalPurchaseRecord($args, intval($rent['cpr_id']));
                if (!is_int($cpr_id)) {
                    return $cpr_id;
                }
            }
        }
        
        $rentrec = [];
        
        if (!$modifying) {
            $rentrec['vehicle_id'] = $args['vehicle_id'];
            $rentrec['renter_id'] = $args['renter_id'];
            $rentrec['daily_price'] = $args['daily_price'];
            $rentrec['date'] = $args['date'];
            
            foreach (['cost_fuel','driver_wages', 'days_ex', 'paidamt','date_return'] as $f) {
                if(isset($args[$f])) {
                    $rentrec[$f] = $args[$f];
                }
            }
            
            if ($cpr_id !== 0) {
                $rentrec['cpr_id'] = $cpr_id;
            }
            
        } else {
            $rentrec['id'] = $args['id'];
            
            foreach (['vehicle_id','renter_id','daily_price','cost_fuel','driver_wages','days_ex','paidamt','date','date_return'] as $f) {
                if(in_array($f, array_keys($args))) {
                    $rentrec[$f] = $args[$f];
                }
            }
            
            if ($cpr_id === 0) {
                $rentrec['cpr_id'] = null;
            } else {
                $rentrec['cpr_id'] = $cpr_id;
            }
        }
        
        if ($this->save($rentrec)) {
            if (!$modifying) {
                return $this->insertID;
            } else {
                return intval($rentrec['id']);
            }
        } else {
            return ['database' => $this->errors()];
        }
    }
}
