<?php namespace App;

use CodeIgniter\Model;

/**
 * Description of ExtendedModel
 *
 * @author rajnish
 */
class ExtendedModel extends Model
{
    protected $availableFields = [];
    protected $searchJsonFields = [];
    protected $searchTableFields = [];
    protected $searchBooleanFields = [];
    protected $filterDFields = [];
    protected $filterNFields = [];
    protected $filterUFields = [];
    protected $orderJsonFields = [];
    protected $orderTableFields = [];
    protected $topResultsFields = [];
    protected $editableFields = [];
    protected $publicFields = [];
    protected $foreignFields = [];
    protected $sumableFields = [];
    protected $statFields = [];
    protected $exportFields = [];

    public function search($builder, $field, $search) {
        if (in_array($field, $this->searchJsonFields)) {
            $builder->having("LOWER(JSON_UNQUOTE(JSON_EXTRACT(". $this->db->escapeIdentifiers(explode('.', $field)[0]) .", "
                    . $this->db->escape("$.".implode('.', array_slice(explode('.', $field), 1))) ."))) LIKE "
                    . "CONCAT('%',LOWER('". $this->db->escapeLikeString($search) ."'),'%') ESCAPE '!'");
        } elseif (in_array($field, $this->searchTableFields)) {
            $builder->havingLike($field, $search, 'both', null, true);
        } elseif (in_array($field, $this->searchBooleanFields)) {
            $builder->havingLike($field, 1);
        } elseif (in_array(str_replace('!', '', $field), $this->searchBooleanFields)) {
            $builder->havingLike(str_replace('!', '', $field), 0);
        }
        return $builder;
    }
    
    public function orSearch($builder, $field, $search) {
        if (in_array($field, $this->searchJsonFields)) {
            $builder->orHaving("LOWER(JSON_UNQUOTE(JSON_EXTRACT(". $this->db->escapeIdentifiers(explode('.', $field)[0]) .", "
                    . $this->db->escape("$.".implode('.', array_slice(explode('.', $field), 1))) ."))) LIKE "
                    . "CONCAT('%',LOWER(". $this->db->escapeLikeString($search) ."),'%') ESCAPE '!'");
        } elseif (in_array($field, $this->searchTableFields)) {
            $builder->orHavingLike($field, $search, 'both', null, true);
        } elseif (in_array($field, $this->searchBooleanFields)) {
            $builder->orHavingLike($field, 1);
        } elseif (in_array(str_replace('!', '', $field), $this->searchBooleanFields)) {
            $builder->orHavingLike(str_replace('!', '', $field), 0);
        }
        return $builder;
    }
    
    public function match($builder, $field, $value) {
        if (in_array($field, $this->filterDFields)) {
            $builder->where($field, $value);
        } elseif (in_array($field, $this->filterNFields)) {
            $num = str_replace(['>','<','='], ['','',''], $value);
            $optype = (strpos($value, '>')===0)?'>':((strpos($value, '>=')===0)?'>=':((strpos($value, '<')===0)?'<':
                    (((strpos($value, '<=')===0))?'<=':'=')));
            $builder->having($field ." ". $optype ." CAST(". $this->db->escape($num) ." AS DECIMAL(5,2))");
        } elseif (in_array($field, $this->filterUFields)) {
            $builder->like($field, $value);
        }
    }
    
    private function orderBy($builder ,$orderby, $order) {
        if (in_array($orderby, $this->orderJsonFields)) {
            $builder->orderBy("JSON_EXTRACT(". $this->db->escapeIdentifiers(explode('.', $orderby)[0]) .","
                    . $this->db->escape("$.".implode('.', array_slice(explode('.', $orderby), 1))) .") ". $order);
        } elseif (in_array($orderby, $this->orderTableFields)) {
            $builder->orderBy($orderby, $order);
        }
        return $builder;
    }
    
    protected function baseQueryBuilder() {
        $sqlsel = "id,";
        foreach ($this->availableFields as $field) {
            if (in_array($field, array_keys($this->foreignFields))) {
                $sqlsel .= ", (". $this->toJsonQuery($this->foreignFields[$field], $this->table .'.'.$field) .") "
                        . "AS ". str_replace('_id', '', $field);
            } else {
                $sqlsel .= ", ". $field;
            }
        }
        return $this->builder()->select($sqlsel);
    }
    
    public function getEntriesInfo($fields = [], $search = null, $filters = [], $fromdate = null, $todate = null)
    {
        $builder = $this->baseQueryBuilder();
        if ($this->useSoftDeletes) {
            $builder->where("deleted_at IS NULL");
        }
        
        if (count($filters) > 0) {
            foreach ($filters as $f => $v) {
                $this->match($builder, $f, $v);
            }
        }
        
        if($search != null && count($fields) > 0) {
            $this->search($builder, $fields[0], $search);
            for($i = 1; $i < count($fields); $i++) {
                $this->orSearch($builder, $fields[$i], $search);
            }
        }
        
        if ($fromdate != null && in_array('date', $this->allowedFields)) {
            $builder->where("date BETWEEN CAST(". $this->db->escape($fromdate)
                    . " AS DATE) AND CAST(".$this->db->escape($todate != null? $todate: $fromdate)." AS DATE)");
        }
        
        $sql = "COUNT(id) as count";
        foreach ($this->sumableFields as $field) {
            $sql .= ", SUM(". $field .") as ". $field;
        }
        $count = db_connect()->query("SELECT ". $sql ." FROM (".$builder->getCompiledSelect().") AS result;")->getRow();
        return $count;
    }
    
    public function getEntries($offset = 0, $count = 0, $orderby = 'date', $order = 'ASC', $fields = [], $search = null, $filters = [],
            $fromdate = null, $todate = null, $builder = null)
    {
        if ($builder === null) {
            $builder = $this->baseQueryBuilder();
        }
        
        $this->orderBy($builder, $orderby, $order);
        
        if ($this->useSoftDeletes) {
            $builder->where("deleted_at IS NULL");
        }
        
        if (count($filters) > 0) {
            foreach ($filters as $f => $v) {
                $this->match($builder, $f, $v);
            }
        }
        
        if($search != null && count($fields) > 0) {
            $this->search($builder, $fields[0], $search);
            for($i = 1; $i < count($fields); $i++) {
                $this->orSearch($builder, $fields[$i], $search);
            }
        }
        
        if ($fromdate != null && in_array('date', $this->allowedFields)) {
            $builder->where("date BETWEEN CAST(". $this->db->escape($fromdate)
                    . " AS DATE) AND CAST(".$this->db
                    ->escape($todate != null? $todate: $fromdate)." AS DATE)");
        }
        
        if($count > 0) {
            $builder->limit ($count, $offset);
        }
        //echo $builder->getCompiledSelect() ."\n\n";
        return $builder->get()->getResult();
    }
    
    public function topResultsFor($field, $search, $count = 10) {
        if (is_string($field) && in_array($field, $this->topResultsFields)) {
            $builder = $this->builder()->select('id,'.$field);
            
            if ($search!=null && $search === '') {
                $builder->like($field, $search);
            }
            $builder->limit($count, 0);
            
            if ($this->useSoftDeletes) {
                $builder->where("deleted_at IS NULL");
            }
            return $builder->get()->getResult();
        }
        return [];
    }

    protected function toJsonQuery($model_name, $idcon = null) {
        $model = model($model_name);
        $sql = "JSON_MERGE('{}', (SELECT JSON_OBJECT('id',id";
        
        foreach ($model->availableFields as $field) {
            if (in_array($field, array_keys($model->foreignFields))) {
                $sql .= ", '".(str_replace('_id', '', $field))."', ". 
                        $this->toJsonQuery($model->foreignFields[$field], $model->table .'.'.$field) ."";
            } else {
                $sql .= ", '". $field ."', ". $field;
            }
        }
        $sql .= ") FROM " . $model->table . " ";
        
        if ($idcon != null) {
            $sql .= "WHERE id = " . $idcon;
        }
        $sql .= '))';
        return $sql;
    }
    
    public function checkAndCorrect($field, $value) {
        if ($field === 'id') {
            return $value;
        }
        switch ($this->editableFields[$field]) {
            case 'bool':
                if (in_array($value, ['on', '1', 'true'])) {
                    return 1;
                } else {
                    return 0;
                }
            case 'date':
                if (in_array($value, ['','0000-00-00 00:00:00', '0000-00-00'])) {
                    return null;
                } else {
                    return $value;
                }
            case 'string':
                if(empty($value)) {
                    return null;
                } else {
                    return $value;
                }
            default: return $value;
        }
    }
    
    public function checkFields($arr, $modifying) {
        helper(['auth']);
        
        $keys = array_keys($arr);
        if (($key = array_search('id', $keys)) !== null) {
            unset($keys[$key]);
        }
        
        if (count(array_intersect($keys, array_keys($this->editableFields))) != count($keys)) {
            return ['request' => 'Invalid parameters in the request!'];
        } elseif ($modifying && !has_permission("app.delete.entry") && count(array_intersect($keys, $this->publicFields)) != count($keys)) {
            return ['permissions' => 'Permission Denied!'];
        }
        return true;
    }
    
    public function saveEntry($arr, $modifying = false) {
        
        if (($res = $this->checkFields($arr, $modifying)) !== true) {
            return $res;
        }
        
        foreach ($arr as $field => $value) {
            $arr[$field] = $this->checkAndCorrect($field, $value);
        }
        
        if ($this->save($arr)) {
            if (!$modifying) {
                return $this->insertID;
            } else {
                return intval($arr['id']);
            }
        } else {
            return ['database' => $this->errors()];
        }
    }
    
    public function formatExport($entry) {
        $out = [];
        array_push($out, $entry['id']);
        foreach ($this->exportFields as $value) {
            if ($value['type'] === 'bool') {
                array_push($out, ($entry[$value['field']] === '1' || $entry[$value['field']] === 1)?'YES':'NO');
            } elseif ($value['type'] === 'decimal') {
                array_push($out, number_format($entry[$value['field']] ,2, '.',''));
            } elseif ($value['type'] === 'date') {
                array_push($out, date_format(date_create($entry[$value['field']]),"d-m-Y"));
            } else if ($value['type'] === 'foreign') {
                array_push($out, json_decode($entry[str_replace('_id', '',  $value['field'])], true)[$value['tablefield']]);
            } else {
                array_push($out, $entry[$value['field']]);
            }
        }
        return $out;
    }
    
    public function exportCSV($orderby = 'date', $order = 'ASC', $fields = [], $search = null, $filters = [],
            $fromdate = null, $todate = null) {
        $count = 25;
        $len = $this->getEntriesInfo($fields, $search, $filters, $fromdate, $todate)->count;
        
        $fp = fopen('php://output', 'w');
        $headers = array_keys($this->exportFields);
        array_unshift($headers, 'ID');
        fputcsv($fp, $headers);
        
        for ($i = 0; $i<$len; $i = $i + $count) {
            $entries = $this->getEntries($i, $count, $orderby, $order, $fields, $search, $filters, $fromdate, $todate);
            foreach ($entries as $entry) {
                fputcsv($fp, $this->formatExport((array)$entry));
            }
        }
        fclose($fp);
    }
    
    // Stats functions
    
    public function getLSYearQuery($date, $field) {
        $selsql = "DATE_FORMAT(`date`, '%Y-%m') AS month, SUM(". $this->statFields[$field].") AS value";
        
        $builder = $this->builder()->select($selsql)
                ->where("`date` BETWEEN (CAST(". $this->db->escape($date)." AS DATE) - INTERVAL 1 YEAR) AND CAST(". $this->db->escape($date)." AS DATE)")
                ->groupBy('`month`');
        return "SELECT CONCAT('{',GROUP_CONCAT(DISTINCT CONCAT('\"',yr.month,'\": ',yr.value) SEPARATOR ', '),'}') AS year FROM (". $builder->getCompiledSelect() .") yr";
    }
    
    public function getLSMonthQuery($date, $field) {
        $selsql = "DATE_FORMAT(`date`, '%m-%d') AS day, SUM(". $this->statFields[$field].") AS value";
        
        $builder = $this->builder()->select($selsql)
                ->where("`date` BETWEEN (CAST(". $this->db->escape($date)." AS DATE) - INTERVAL 1 MONTH) AND CAST(". $this->db->escape($date)." AS DATE)")
                ->groupBy('`day`');
        return "SELECT CONCAT('{',GROUP_CONCAT(DISTINCT CONCAT('\"',mr.day,'\": ',mr.value) SEPARATOR ', '),'}') AS month FROM (". $builder->getCompiledSelect() .") mr";
    }
    
    public function getLSWeekQuery($date, $field) {
        $selsql = "DATE_FORMAT(`date`, '%u-%d-%m') AS day, SUM(". $this->statFields[$field].") AS value";
        
        $builder = $this->builder()->select($selsql)
                ->where("`date` BETWEEN (CAST(". $this->db->escape($date)." AS DATE) - INTERVAL 1 WEEK) AND CAST(". $this->db->escape($date)." AS DATE)")
                ->groupBy('`day`');
        return "SELECT CONCAT('{',GROUP_CONCAT(DISTINCT CONCAT('\"',wr.day,'\": ',wr.value) SEPARATOR ', '),'}') AS week FROM (". $builder->getCompiledSelect() .") wr";
    }
    
    public function getLastStats($date, $field) {
        if (empty($this->statFields) || !in_array($field, array_keys($this->statFields))) {
            return json_encode(['errors' => ['request' => 'Unsupported Request!']]);
        }
        
        $sql = "SELECT JSON_OBJECT('week', JSON_MERGE('{}', IF(w.week IS NULL,'{}',w.week)), "
                . "'month', JSON_MERGE('{}', IF(m.month IS NULL,'{}',m.month)), "
                . "'year', JSON_MERGE('{}',IF(y.year IS NULL,'{}',y.year))) AS stats "
                . "FROM ". "(".$this->getLSWeekQuery($date, $field).") w, (".$this->getLSMonthQuery($date, $field).") m, "
                . "(". $this->getLSYearQuery($date, $field).") y ;";
        
        $row = db_connect()->query($sql)->getRow();
        
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
}
