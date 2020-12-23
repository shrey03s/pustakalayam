<?php namespace App\Database\Seeds;

class AuthSeeder extends \CodeIgniter\Database\Seeder
{
    private function check_add_permission($auth,$name, $description) {
        if($auth->permission($name) == NULL) {
            return $auth->createPermission($name, $description);
        }
    }

    public function run()
    {
        $auth = \Myth\Auth\Config\Services::authorization();
        $users = model('UserModel');
        
        $attendance_permission_id = $this->check_add_permission($auth, 'app.attendance', 'Allows a user to manage attendance');
        $salary_permission_id = $this->check_add_permission($auth, 'app.salary', 'Allows a user to manage salary');
        $delete_permission_id = $this->check_add_permission($auth, 'app.delete.entry', 'Allows a user to delete entry');
        
        if($auth->group('owner') == NULL) {
            $grp_id = $auth->createGroup('owner', 'Group of business owners');
            $auth->addPermissionToGroup($attendance_permission_id, $grp_id);
            $auth->addPermissionToGroup($salary_permission_id, $grp_id);
            $auth->addPermissionToGroup($delete_permission_id, $grp_id);
        }
        if($auth->group('manager') == NULL) {
            $grp_id = $auth->createGroup('manager', 'Group of business managers');
            $auth->addPermissionToGroup($attendance_permission_id, $grp_id);
            $auth->addPermissionToGroup($salary_permission_id, $grp_id);
        }
        if($auth->group('worker') == NULL) {
            $auth->createGroup('worker', 'Group of business workers');
        }
        
        $usrs = $users->findColumn('username');
        if($usrs == NULL || in_array('owner', $usrs)) {
            $usr = new \Myth\Auth\Entities\User();
        
            $usr->username = 'owner';
            $usr->email = 'owner@owner.com';
            $usr->password = 'Abc@123';

            $usr->activate();
            
            $users->withGroup('owner');

            $users->save($usr);
        }
    }
}