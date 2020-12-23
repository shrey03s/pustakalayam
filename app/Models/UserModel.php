<?php 

namespace App\Models;

use Myth\Auth\Models\UserModel;

class UserModelExtend extends UserModel {
    
    protected $validationRules = [
        'email'         => 'required|valid_email|is_softunique[users.email,id,{id}]',
        'username'      => 'required|alpha_numeric_punct|min_length[3]|is_softunique[users.username,id,{id}]',
        'password_hash' => 'required',
    ];
    
    public function getEntriesInfo($filter= [], $search = NULL) {
        $builder = $this->builder();
        
        $bld = $builder->join('auth_groups_users', 'users.id=auth_groups_users.user_id', 'left')
                        ->join('auth_groups', 'auth_groups.id=auth_groups_users.group_id','left')
                        ->select('users.id, users.username, users.email, auth_groups_users.group_id')
                        ->groupBy('username');
        
        if ($this->useSoftDeletes) {
            $bld->where("deleted_at IS NULL");
        }
        
        if($search != NULL && count($filter) != 0) {
            $bld->like($filter[0], $search);

            for($i = 1; $i < count($filter); $i++) {
                $bld->orLike($filter[$i], $search);
            }
        }
        
        $count = db_connect()->query("SELECT COUNT(id) as count FROM (".$bld->getCompiledSelect().") AS result;")->getRow();
        return $count;
    }
    
    public function getEntries($offset = 0, $count = 0, $orderby = 'id', $order = 'DESC', $filter = [], $search = null) {
        $builder = $this->builder();
        
        $bld =  $builder->join('auth_groups_users', 'users.id=auth_groups_users.user_id', 'left')
                        ->join('auth_groups', 'auth_groups.id=auth_groups_users.group_id','left')
                        ->groupBy('username')
                        ->orderBy($orderby, $order);
        if ($this->useSoftDeletes) {
            $bld->where("deleted_at IS NULL");
        }
        
        if($search != NULL && count($filter) != 0) {
            $bld->like($filter[0], '%'.$search.'%');

            for($i = 1; $i < count($filter); $i++) {
                $bld->orLike($filter[$i], '%'.$search.'%');
            }
        }
        
        $bld->limit($count, $offset)
            ->select('users.id as id, users.username as username, users.email as email, , GROUP_CONCAT(auth_groups.name) As groups ');
        
        return $bld ->get()->getResult();
    }
}
