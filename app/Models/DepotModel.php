<?php namespace App\Models;

use App\ExtendedModel;

/**
 * Description of MineDest
 *
 * @author rajnish
 */
class DepotModel extends ExtendedModel
{
    protected $table = 'depot';
    protected $primaryKey = 'id';
    
    protected $returnType = 'array';
    protected $availableFields = ['name', 'incharge', 'phone', 'email', 'address', 'city', 'state', 'country', 'area_pin', 'rawamt', 'cookamt'];
    protected $allowedFields = ['name', 'incharge', 'phone', 'email', 'address', 'city', 'state', 'country', 'area_pin'];
    protected $useTimestamps = true;
    protected $useSoftDeletes = true;

    protected $validationRules    = [
        'name'          => 'required|min_length[1]|max_length[100]|string|is_softunique[depot.name,id,{id}]',
        'incharge'      => 'required|min_length[1]|max_length[100]|string',
        'phone'         => 'permit_empty|max_length[20]|alpha_numeric_punct',
        'email'         => 'permit_empty|max_length[255]|valid_email',
        'address'       => 'permit_empty|max_length[255]|string',
        'city'          => 'permit_empty|max_length[100]|string',
        'state'         => 'permit_empty|max_length[100]|string',
        'country'       => 'permit_empty|max_length[100]|string',
        'area_pin'      => 'permit_empty|max_length[10]|alpha_numeric'
    ];
    protected $validationMessages = [
        'name'  => [
            'required'      => "Depot name is required!",
            'min_length'    => "Depot name must have at least {param} characters!",
            'max_length'    => "Depot name can not be more than {param} characters!",
            'string'        => "Depot name contains illegal characters!",
            'is_softunique' => "The Depot name `{value}` is already registered!"
        ],
        'incharge'  => [
            'required'      => "Depot's Incharge name is required!",
            'min_length'    => "Depot's Incharge name must have at least {param} characters!",
            'max_length'    => "Depot's Incharge name can not be more than {param} characters!",
            'string'        => "Depot's Incharge name contains illegal characters!"
        ],
        'phone' => [
            'max_length'    => "Depot's phone number can not be more than {param} digits!",
            'alpha_numeric_punct' => "Depot's phone number contains illegal characters!"
        ],
        'email' => [
            'max_length'    => "Depot's email can not be more than {param} characters!",
            'valid_email'   => "Depot's email must be a valid one!"
        ],
        'address'   => [
            'max_length'    => "Depot adresss must not be more than {param} characters!",
            'string'        => "Depot address contains illegal characters!"
        ],
        'city' => [
            'max_length'    => "Depot's city name can not be more than {param} characters!",
            'string'        => "Depot's city name contains illegal characters!"
        ],
        'state' => [
            'max_length'    => "Depot's state name can not be more than {param} characters!",
            'string'        => "Depot's state name contains illegal characters!"
        ],
        'country' => [
            'max_length'    => "Depot's state name can not be more than {param} characters!",
            'string'        => "Depot's state name contains illegal characters!"
        ],
        'area_pin' => [
            'max_length'    => "Depot's area pincode can not be more than {param} characters!",
            'alpha_numeric' => "Depot's area pincode contains illegal characters!"
        ]
    ];
    protected $skipValidation       = false;
    
    protected $searchTableFields    = ['name', 'incharge', 'phone', 'email', 'city', 'state', 'country', 'area_pin'];
    protected $filterUFields        = ['name', 'incharge', 'phone', 'email', 'city', 'state', 'country', 'area_pin'];
    protected $filterNFields        = ['rawamt', 'cookamt'];
    protected $orderTableFields     = ['name', 'incharge', 'phone', 'email', 'city', 'state', 'rawamt', 'cookamt'];
    protected $topResultsFields     = ['name'];
    protected $editableFields = [
        'name'      => 'string',
        'incharge'  => 'string',
        'phone'     => 'string',
        'email'     => 'string',
        'address'   => 'string',
        'city'      => 'string',
        'state'     => 'string',
        'country'   => 'string',
        'area_pin'  => 'string'        
    ];
    
    protected $exportFields = [
        'Name'              => ['field' => 'name', 'type' => 'string'],
        'Incharge'          => ['field' => 'incharge', 'type' => 'string'],
        'Phone'             => ['field' => 'phone', 'type' => 'string'],
        'Email'             => ['field' => 'email', 'type' => 'string'],
        'Address'           => ['field' => 'address', 'type' => 'string'],
        'City'              => ['field' => 'city', 'type' => 'string'],
        'State'             => ['field' => 'state', 'type' => 'string'],
        'Country'           => ['field' => 'country', 'type' => 'string'],
        'Pin'               => ['field' => 'area_pin', 'type' => 'string'],
        'Raw Amount'        => ['field' => 'rawamt', 'type' => 'decimal'],
        'Processed Amount'  => ['field' => 'cookamt', 'type' => 'decimal']
    ];
    
    protected function baseQueryBuilder() {
        return $this->builder()->select('id,`name`,incharge,phone,email,address,city,state,country,area_pin,rawamt,cookamt');
    }
    
    public function getDepots() {
        return $this->builder()->select('id,`name`,rawamt,cookamt')->get()->getResult();
    }
    
    public function getTotalCoals() {
        $builder = $this->builder()->select('SUM(rawamt) as raw, SUM(cookamt) as cook');
        return $builder->get()->getRow();
    }
    
    public function getAssets($depot, $count = 0, $offset = 0) {
        $builder = $this->builder('stat_assets')
                ->select('(SELECT name FROM `asset_types` WHERE id = type_id) as name, amount')
                ->where('depot_id', $depot);
        
        if ($count >0) {
            $builder->limit($count, $offset);
        }
        
        return $builder->get()->getResult();
    }
    
    public function getAssetsCount($depot) {
        $builder = $this->builder('stat_assets')
                ->select('COUNT(id) as count')
                ->where('depot_id', $depot);
        return $builder->get()->getResult();
    }
    
    private function getTLSStat($field, $basequery, $date, $calc = null) {
        if ($calc === null) {
            $calc = "SUM(". $field .")";
        }
        $yearsql = ""
                . "SELECT CONCAT('{',GROUP_CONCAT(DISTINCT CONCAT('\"',yr.month,'\": ',yr.value) SEPARATOR ', '),'}') AS year FROM ("
                . "     SELECT DATE_FORMAT(`date`, '%Y-%m') AS month, ".$calc." AS value FROM (".$basequery.") bt "
                . "     WHERE `date` BETWEEN (CAST(". $this->db->escape($date) ." AS DATE) - INTERVAL 1 YEAR) AND CAST(". $this->db->escape($date) ." AS DATE)"
                . "     GROUP BY `month`"
                . ") yr";
        $monthsql = ""
                . "SELECT CONCAT('{',GROUP_CONCAT(DISTINCT CONCAT('\"',mr.day,'\": ',mr.value) SEPARATOR ', '),'}') AS month FROM ("
                . "     SELECT DATE_FORMAT(`date`, '%m-%d') AS day, ".$calc." AS value FROM (".$basequery.") bt "
                . "     WHERE `date` BETWEEN (CAST(". $this->db->escape($date) ." AS DATE) - INTERVAL 1 MONTH) AND CAST(". $this->db->escape($date) ." AS DATE)"
                . "     GROUP BY `day`"
                . ") mr";
        $weeksql = ""
                . "SELECT CONCAT('{',GROUP_CONCAT(DISTINCT CONCAT('\"',wr.day,'\": ',wr.value) SEPARATOR ', '),'}') AS week FROM ("
                . "     SELECT DATE_FORMAT(`date`, '%u-%d-%m') AS day, ".$calc." AS value FROM (".$basequery.") bt "
                . "     WHERE `date` BETWEEN (CAST(". $this->db->escape($date) ." AS DATE) - INTERVAL 1 WEEK) AND CAST(". $this->db->escape($date) ." AS DATE)"
                . "     GROUP BY `day`"
                . ") wr";
        $mainsql = "SELECT JSON_OBJECT('week', JSON_MERGE('{}', IF(w.week IS NULL,'{}',w.week)), "
                . "'month', JSON_MERGE('{}', IF(m.month IS NULL,'{}',m.month)), "
                . "'year', JSON_MERGE('{}',IF(y.year IS NULL,'{}',y.year))) AS stats "
                . "FROM (".$weeksql.") w, (".$monthsql.") m, (".$yearsql.") y ;";
        
        $row = db_connect()->query($mainsql)->getRow();
        
        if ($row !== null) {
            return $row->stats;
        } else {
            if ($this->errors()) {
                return json_encode(['errors' => ['database' => $this->errors()]]);
            } else {
                return json_encode(new \stdClass());
            }
        }
    }
    
    public function getIncomeStat($date) {
        $basequery = ""
                . "(SELECT `date`, price AS income FROM `coal_sold_record`) UNION "
                . "(SELECT `date`, (`paidamt` - IF(`cpr_id` IS NULL, 0, (SELECT price FROM `coal_purchased_record` WHERE id = cpr_id))) AS income "
                . "FROM `rent_record`)";
        return $this->getTLSStat('income', $basequery, $date);
    }
    
    public function getExpenseStat($date) {
        $basequery = ""
                . "(SELECT `date`, (JSON_ARRSUM(JSON_EXTRACT(expenses, '$.*'))) AS expenses FROM `mining_record`) UNION "
                . "(SELECT `date`, price AS expenses FROM `coal_purchased_record`) UNION "
                . "(SELECT `date`, (JSON_ARRSUM(JSON_EXTRACT(expenses, '$.*'))) AS expenses FROM `coal_processed_record`) UNION "
                . "(SELECT `date`, cost AS expenses FROM `assets_record`) UNION "
                . "(SELECT `date`, ROUND(((`payamt`*`timeamt`)- (((`payamt`*`timeamt`)*`tax`)/100) + "
                . "     (JSON_ARRSUM(JSON_EXTRACT(addjson, '$.*'))) - (JSON_ARRSUM(JSON_EXTRACT(dedjson, '$.*')))),2) AS expenses FROM `payroll_record`)";
        
        return $this->getTLSStat('expenses', $basequery, $date);
    }
    
    public function getProfitStat($date) {
        $basequery = ""
                . "(SELECT `date`, price AS income, 0 AS expenses FROM `coal_sold_record`) UNION "
                . "(SELECT `date`, (`paidamt` - IF(`cpr_id` IS NULL, 0, (SELECT price FROM `coal_purchased_record` WHERE id = cpr_id))) AS income, 0 AS expenses "
                . "FROM `rent_record`) UNION"
                . "(SELECT `date`,0 AS income ,(JSON_ARRSUM(JSON_EXTRACT(expenses, '$.*'))) AS expenses FROM `mining_record`) UNION "
                . "(SELECT `date`,0 AS income, price AS expenses FROM `coal_purchased_record`) UNION "
                . "(SELECT `date`,0 AS income, (JSON_ARRSUM(JSON_EXTRACT(expenses, '$.*'))) AS expenses FROM `coal_processed_record`) UNION "
                . "(SELECT `date`,0 AS income, cost AS expenses FROM `assets_record`) UNION "
                . "(SELECT `date`,0 AS income, ROUND(((`payamt`*`timeamt`)- (((`payamt`*`timeamt`)*`tax`)/100) + "
                . "     (JSON_ARRSUM(JSON_EXTRACT(addjson, '$.*'))) - (JSON_ARRSUM(JSON_EXTRACT(dedjson, '$.*')))),2) AS expenses FROM `payroll_record`)";
        return $this->getTLSStat(null, $basequery, $date, "(SUM(`income`)-SUM(`expenses`))");
    }
    
    public function getRawCoalINStat($date) {
        $basequery = ""
                . "(SELECT `date`, amount AS coal FROM `mining_record`) UNION "
                . "(SELECT `date`, IF(`is_processed`,0,amount) AS coal FROM `coal_purchased_record`)";
        
        return $this->getTLSStat('coal', $basequery, $date);
    }
    
    public function getRawCoalOUTStat($date) {
        $basequery = ""
                . "(SELECT `date`, IF(`is_processed`,0,amount) AS coal FROM `coal_sold_record`) UNION "
                . "(SELECT `date`, amount_in AS coal FROM `coal_processed_record`)";
        
        return $this->getTLSStat('coal', $basequery, $date);
    }
    
    public function getCookedCoalINStat($date) {
        $basequery = ""
                . "(SELECT `date`, IF(`is_processed`,amount,0) AS coal FROM `coal_purchased_record`) UNION "
                . "(SELECT `date`, amount_out AS coal FROM `coal_processed_record`)";
        
        return $this->getTLSStat('coal', $basequery, $date);
    }
    
    public function getCookedCoalOUTStat($date) {
        $basequery = "SELECT `date`, IF(`is_processed`,amount,0) AS coal FROM `coal_sold_record`";
        
        return $this->getTLSStat('coal', $basequery, $date);
    }
}
