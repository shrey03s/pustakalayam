<?php namespace App\Validation;

use Config\Database;

/**
 * Description of ExtendedFormValidation
 *
 * @author rajnish
 */
class ExtendedFormValidation
{
    public function is_softunique(string $str = null, string $field, array $data): bool
    {
        list($field, $ignoreField, $ignoreValue) = array_pad(explode(',', $field), 3, null);
        sscanf($field, '%[^.].%[^.]', $table, $field);
        $db = Database::connect($data['DBGroup'] ?? null);
        $row = $db->table($table)
                ->select('1')
                ->where($field, $str)
                ->where('deleted_at', null)
                ->limit(1);
        
        if (! empty($ignoreField) && ! empty($ignoreValue)) {
            if (! preg_match('/^\{(\w+)\}$/', $ignoreValue)) {
                $row = $row->where("{$ignoreField} !=", $ignoreValue);
            }
        }
        
        return (bool) ($row->get()->getRow() === null);
    }
    
    public function bool(string $str = null): bool {
        return in_array($str, ['true', 'false', '0', '1', 0, 1]);
    }
}
