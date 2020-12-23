<?php namespace App\Controllers;

class Control extends BaseController
{
    private function check_and_view($name, $data = array())
    {
        helper('auth');
        if(!logged_in()) {
            return view('welcome_page/welcome_page');
        } else {
            return view($name, $data);
        }
    }

    public function index()
    {
        $data['page']   = new \App\StatsPages\Dashboard();
        return $this->check_and_view('dashboard/layout/_stats_page', $data);
    }
    
    public function mining($action = 'none') 
    {
        $data['action'] = $action;
        $data['page']   = new \App\Pages\MiningRecord();
        return $this->check_and_view('dashboard/layout/_record_page', $data);
    }
    
    public function depots($action = 'none') 
    {
        $data['action'] = $action;
        $data['page']   = new \App\Pages\Depot();
        return $this->check_and_view('dashboard/layout/_record_page', $data);
    }
    
    public function mines($action = 'none') 
    {
        $data['action'] = $action;
        $data['page']   = new \App\Pages\Mine();
        return $this->check_and_view('dashboard/layout/_record_page', $data);
    }
    
    public function vehicles($action = 'none') 
    {
        $data['action'] = $action;
        $data['page']   = new \App\Pages\Vehicles();
        return $this->check_and_view('dashboard/layout/_record_page', $data);
    }
    
    public function purchased($action = 'none') 
    {
        $data['action'] = $action;
        $data['page']   = new \App\Pages\CoalPurchasedRecord();
        return $this->check_and_view('dashboard/layout/_record_page', $data);
    }
    
    public function sold($action = 'none') 
    {
        $data['action'] = $action;
        $data['page']   = new \App\Pages\CoalSoldRecord();
        return $this->check_and_view('dashboard/layout/_record_page', $data);
    }
    
    public function processed($action = 'none') 
    {
        $data['action'] = $action;
        $data['page']   = new \App\Pages\CoalProcessedRecord();
        return $this->check_and_view('dashboard/layout/_record_page', $data);
    }
    
    public function customers($action = 'none') 
    {
        $data['action'] = $action;
        $data['page']   = new \App\Pages\CoalCustomers();
        return $this->check_and_view('dashboard/layout/_record_page', $data);
    }
    
    public function suppliers($action = 'none') 
    {
        $data['action'] = $action;
        $data['page']   = new \App\Pages\CoalSuppliers();
        return $this->check_and_view('dashboard/layout/_record_page', $data);
    }
    
    public function rent($action = 'none') 
    {
        $data['action'] = $action;
        $data['page']   = new \App\Pages\RentRecord();
        return $this->check_and_view('dashboard/layout/_record_page', $data);
    }
    
    public function renters($action = 'none') 
    {
        $data['action'] = $action;
        $data['page']   = new \App\Pages\Renters();
        return $this->check_and_view('dashboard/layout/_record_page', $data);
    }
    
    public function assets($action = 'none')
    {
        $data['action'] = $action;
        $data['page']   = new \App\Pages\AssetsRecord();
        return $this->check_and_view('dashboard/layout/_record_page', $data);
    }
    
    public function assettypes($action = 'none') 
    {
        $data['action'] = $action;
        $data['page']   = new \App\Pages\AssetType();
        return $this->check_and_view('dashboard/layout/_record_page', $data);
    }
        
    public function attendance($action = 'none') 
    {
        $data['action'] = $action;
        $data['page']   = new \App\Pages\AttendanceRecord();
        return $this->check_and_view('dashboard/layout/_record_page', $data);
    }
    
    public function attendancebulk($action = 'none') 
    {
        $data['action'] = $action;
        return $this->check_and_view('dashboard/bulk/page', $data);
    }
    
    public function payroll($action = 'none') 
    {
        $data['action'] = $action;
        $data['page']   = new \App\Pages\PayrollRecord();
        return $this->check_and_view('dashboard/layout/_record_page', $data);
    }
    
    public function accounts($action = 'none') 
    {
        $data['action'] = $action;
        $data['page']   = new \App\Pages\Accounts();
        return $this->check_and_view('dashboard/layout/_record_page', $data);
    }
    
    public function employees($action = 'none') 
    {
        $data['action'] = $action;
        $data['page']   = new \App\Pages\Employees();
        return $this->check_and_view('dashboard/layout/_record_page', $data);
    }
    
    public function departmenttypes($action = 'none') 
    {
        $data['action'] = $action;
        $data['page']   = new \App\Pages\DepartmentType();
        return $this->check_and_view('dashboard/layout/_record_page', $data);
    }
    
    public function profile($action = 'none') 
    {
        $data['action'] = $action;
        return $this->check_and_view('dashboard/profile/page', $data);
    }  
    
    // Stats
    public function depotstat($action = 'none') 
    {
        $data['action'] = $action;
        $data['page']   = new \App\StatsPages\Depot();
        return $this->check_and_view('dashboard/layout/_stats_page', $data);
    }
    
    public function miningstat($action = 'none') 
    {
        $data['action'] = $action;
        $data['page']   = new \App\StatsPages\Mining();
        return $this->check_and_view('dashboard/layout/_stats_page', $data);
    }
    
    public function coalstat($action = 'none') 
    {
        $data['action'] = $action;
        $data['page']   = new \App\StatsPages\CoalUtility();
        return $this->check_and_view('dashboard/layout/_stats_page', $data);
    }
    
    public function moneystat($action = 'none') 
    {
        $data['action'] = $action;
        $data['page']   = new \App\StatsPages\Money();
        return $this->check_and_view('dashboard/layout/_stats_page', $data);
    }
}
