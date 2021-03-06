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
        $data['action'] = '';
        $data['page']   = new \App\Pages\Books();
        return $this->check_and_view('dashboard/layout/_record_page', $data);
    }
    
    public function books($action = 'none') 
    {
        $data['action'] = $action;
        $data['page']   = new \App\Pages\Books();
        return $this->check_and_view('dashboard/layout/_record_page', $data);
    }
    
    public function issue($action = 'none') 
    {
        $data['action'] = $action;
        $data['page']   = new \App\Pages\IssueRecord();
        return $this->check_and_view('dashboard/layout/_record_page', $data);
    }
    
    public function visitors($action = 'none') 
    {
        $data['action'] = $action;
        $data['page']   = new \App\Pages\VisitorsRecord();
        return $this->check_and_view('dashboard/layout/_record_page', $data);
    }
    
    public function accounts($action = 'none') 
    {
        $data['action'] = $action;
        $data['page']   = new \App\Pages\Accounts();
        return $this->check_and_view('dashboard/layout/_record_page', $data);
    }
    
    public function members($action = 'none') 
    {
        $data['action'] = $action;
        $data['page']   = new \App\Pages\Members();
        return $this->check_and_view('dashboard/layout/_record_page', $data);
    }
    
    public function membership($action = 'none') 
    {
        $data['action'] = $action;
        $data['page']   = new \App\Pages\MembershipRecord();
        return $this->check_and_view('dashboard/layout/_record_page', $data);
    }
    
    public function profile($action = 'none') 
    {
        $data['action'] = $action;
        return $this->check_and_view('dashboard/profile/page', $data);
    }
}
