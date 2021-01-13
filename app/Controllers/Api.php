<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class Api extends Controller 
{
    private $serv = [
        'accounts'      => 'UserModel',
        'issue'         => 'IssueRecordModel',
        'membership'   => 'MembershipRecordModel',
        'books'         => 'BooksModel',
        'members'       => 'MembersModel',
        'visitors'      => 'VisitorsRecordModel'
    ];
    
    private function getParams($key, $default = null) {
        return $this->request->getPost($key) != null ? $this->request->getPost($key) : $default;
    }
    private function getGetParams($key, $default = null) {
        return $this->request->getGet($key) != null ? $this->request->getGet($key) : $default;
    }
    private function getJsonParam($key) {
        $res = json_decode($this->getParams($key, '[]'), true);
        return ($res==null)?[]:$res;
    }
    private function getGetJsonParam($key) {
        $res = json_decode($this->getGetParams($key, '[]'), true);
        return ($res==null)?[]:$res;
    }
    
    private function getModel() {
        if ($this->request->getPost('model') == null || !isset($this->serv[$this->request->getPost('model')])) {
            return false;
        }
        return model($this->serv[$this->request->getPost('model')]);
    }
    
    private function getGetModel() {
        if ($this->request->getGet('model') == null || !isset($this->serv[$this->request->getGet('model')])) {
            return false;
        }
        return model($this->serv[$this->request->getGet('model')]);
    }
    
    private function convertJson($arr) {
        foreach ($arr as $key => $value) {
            $json = json_decode($value, false);
            if (is_object($json) || is_array($json)) {
                $arr[$key] = $json;
            }
        }
        return $arr;
    }
    
    private function traverseJson($arr) {
        foreach ($arr as $key => $val) {
            $arr[$key] = self::convertJson((array)$val);
        }
        return json_encode($arr);
    }
    
    private function newValidateRules($forarr, $rules) {
        $mrules = [];
        foreach ($forarr as $key => $value) {
            if ($key == 'id') {
                continue;
            }
            if (array_key_exists($key, $rules)) {
                $mrules[$key] = $rules[$key];
            }
        }
        return $mrules;
    }
    
    public function entries()
    {
        $errs = [];
        $model = $this->getModel();
        if ($model == false) {
            $errs['errors']['request'] = "Invalid Request!";
            return json_encode($errs);
        }
        
        $res = $model->getEntries($this->getParams('offset', 0), $this->getParams('count', 0), $this->getParams('orderby', 'id'),
                $this->getParams('order', 'ASC'), $this->getJsonParam('fields'), $this->getParams('search'), 
                $this->getJsonParam('filters'), $this->getParams('fromdate'), $this->getParams('todate'));
        if ($res !== null) {
            return $this->traverseJson($res);
        } else {
            $errs['errors']['database'] = $model->errors();
            return json_encode($errs);
        }
    }
    
    public function entriesinfo()
    {
        $errs = [];
        $model = $this->getModel();
        if ($model == false) {
            $errs['errors']['request'] = "Invalid Request!";
            return json_encode($errs);
        }
        
        $res = $model->getEntriesInfo($this->getJsonParam('fields'), $this->getParams('search'), 
                $this->getJsonParam('filters'), $this->getParams('fromdate'), $this->getParams('todate'));
        if ($res !== null) {
            return json_encode($res);
        } else {
            if ($model->errors()) {
                $errs['errors']['database'] = $model->errors();
                return json_encode($errs);
            } else {
                return json_encode([ 'count' => 0 ]);
            }
        }
    }
    
    public function topresults()
    {
        $errs = [];
        $model = $this->getModel();
        if ($model == false) {
            $errs['errors']['request'] = "Invalid Request!";
            return json_encode($errs);
        } elseif ($this->request->getPost('field')==null) {
            $errs['errors']['request'] = "Missing paramters `field`!";
            return json_encode($errs);
        }
        
        $res = $model->topResultsFor(
                $this->getParams('field'),
                $this->getParams('search'),
                $this->getParams('count', 10));
        if ($res !== null) {
            return json_encode($res);
        } else {
            $errs['errors']['database'] = $model->errors();
            return json_encode($errs);
        }
    }
    
    public function putentry()
    {
        $errs = [];
        $model = $this->getModel();
        if ($model == false) {
            $errs['errors']['request'] = "Invalid Request!";
            return json_encode($errs);
        }
        
        $modifying = (array_key_exists('id', $this->request->getPost()) || array_key_exists('ID', $this->request->getPost()));
        $rules = $model->getValidationRules();
        if ($modifying) {
            $rules = $this->newValidateRules($this->request->getPost(), $rules);
        }
        
        $args = $this->request->getPost();
        
        if (!$this->validate($rules, $model->getValidationMessages())) {
            $errs['errors']['validation'] = $this->validator->getErrors();
            return json_encode($errs);
        }
        
        unset($args['model']);
        $res = $model->saveEntry($args, $modifying);
        if (is_int($res)) {
            return json_encode(['id' => $res]);
        } else {
            $errs['errors'] = $res;
            return json_encode($errs);
        }
    }
    
    public function saveuser()
    {
        helper(['auth']);
        $res = [];
                
        if(!has_permission('app.delete.entry')) {
            $res['errors']['request'] = 'Premission Denied';
            return json_encode($res);
        }
        
        $authorize = \Myth\Auth\Config\Services::authorization();
        $this->config = config('Auth');
        $model = model('UserModel');
        $id = $this->request->getPost('id');
        
        $modifing = ($id != null);
        if($modifing && !has_permission('app.delete.entry')) {
            $res['errors']['request'] = 'Premission Denied';
            return json_encode($res);
        }
        
        $rules = [];
        $ruleerrors = [];
        if($modifing) {
            if($this->request->getPost('username') != null) {
                $rules['username']  = 'permit_empty|alpha_numeric_punct|min_length[3]|is_softunique[users.username,id,{id}]';
                $ruleerrors['username'] = ['is_softunique' => "The given username is already registered!"];
            }
            if($this->request->getPost('email') != null) {
                $rules['email']     = 'permit_empty|valid_email|is_softunique[users.email,id,{id}]';
                $ruleerrors['email'] = ['is_softunique' => "The given email is already registered!"];
            }
            if($this->request->getPost('groups') != null) {
                $rules['groups']     = 'alpha_numeric';
            }
        } else {
            $rules['username']      = 'required|alpha_numeric_punct|min_length[3]|is_softunique[users.username,id,{id}]';
            $rules['email']         = 'required|valid_email|is_softunique[users.email,id,{id}]';
            $rules['password']      = 'required|min_length[8]|string';
            $rules['pass_confirm']  = 'required|matches[password]';
            $rules['groups']        = 'alpha_numeric';
            
            $ruleerrors['username'] = ['is_softunique' => "The given username is already registered!"];
            $ruleerrors['email'] = ['is_softunique' => "The given email is already registered!"];
        }
                
        if (!$this->validate($rules, $ruleerrors)) {
            $res['errors']['validation'] = $this->validator->getErrors();
            return json_encode($res);
        }
        
        $fields = ['username', 'email'];
        
        if(!$modifing) {
            array_push($fields, 'password');
        }
        
        $user = new \Myth\Auth\Entities\User($this->request->getPost());
        
        $user->activate();
        
        if($modifing) {
            $user->id = $id;
        } else {
            $model->withGroup($this->request->getPost('groups'));
        }
        
        if (!$model->save($user)) {
            $res['errors']['request'] = 'Invalid Request!';
            return json_encode($res);
        }
        
        if($modifing) {
            $group = $this->request->getPost('groups');
            $grps = array_diff(['owner', 'staff'], [$group]);
            foreach ($grps as $grp) {
                if($authorize->inGroup($grp, $id)) {
                    $authorize->removeUserFromGroup($id, $grp);
                }
            }
            if(!$authorize->inGroup($group, $id)) {
                $authorize->addUserToGroup($id, $group);
            }
        }
        
        return json_encode(['success' => true]);
    }
    
    public function changepass() {
        helper(['auth']);
        $this->config = config('Auth');
        $model = model('UserModel');
        
        $res = [];
        
        if($this->request->getPost('id') == null) {
            $res['errors']['request'] = 'Invalid Request up!';
            return json_encode($res);
        }
        
        if(!has_permission('app.delete.entry') && intval($this->request->getPost('id')) !== user_id()) {
            $res['errors']['request'] = 'Premission Denied';
            return json_encode($res);
        }
        
        if (!$this->validate([
            'password'      => 'required|min_length[8]|string',
            'pass_confirm'  => 'required|matches[password]'
        ])) {
            $res['errors']['validation'] = $this->validator->getErrors();
            return json_encode($res);
        }
        
        if (user_id() !== intval($this->request->getPost('id')) &&
                !has_permission("app.delete.entry")) {
            $res['errors']['permissions'] = 'Permission Denied!';
            return json_encode($res);
        }
    
        $user = new \Myth\Auth\Entities\User($this->request->getPost(['id','password']));
                
        if (! $model->save($user)) {
            $res['errors']['request'] = 'Invalid Request down!';
            return json_encode($res);
        }
        
        return json_encode(['success' => true]);
    }
    
    public function delete()
    {
        helper(['auth']);
        
        $errs = [];
        $model = $this->getModel();
        if ($model == false) {
            $errs['errors']['request'] = "Invalid Request!";
        } elseif (!$this->validate([ 'id' => 'required' ])) {
            $errs['errors']['validation'] = $this->validator->getErrors();
        } elseif (!has_permission('app.delete.entry')) {
            $errs['errors']['permissions'] = 'Permission Denied!';
        } else {
            $res = $model->delete($this->request->getPost('id'));
            if ($res == true) {
                return json_encode(['success' => true]);
            } else {
                $errs['errors']['result'] = 'Failed to save the contents!';
            }
        }
        return json_encode($errs);
    }
    
    public function entrybyid() 
    {
        $errs = [];
        $model = $this->getModel();
        //$m = new \App\Models\AssetsRecordModel();
        
        if ($model == false) {
            $errs['errors']['request'] = "Invalid Request!";
            return json_encode($errs);
        } elseif ($this->request->getPost('id')==null) {
            $errs['errors']['request'] = "Missing paramters `id` !";
            return json_encode($errs);
        }
        
        $res= $model->find($this->request->getPost('id'));
        if ($res !== null) {
            return json_encode($res);
        } else {
            $errs['errors']['database'] = $model->errors();
            return json_encode($errs);
        }
    }
    
    public function laststats()
    {
        $errs = [];
        $model = $this->getModel();
        if ($model == false) {
            $errs['errors']['request'] = "Invalid Request!";
            return json_encode($errs);
        }
        
        if ($this->request->getPost('date')==null || $this->request->getPost('field')==null) {
            $errs['errors']['request'] = "Missing parameters!";
            return json_encode($errs);
        }
        
        return $model->getLastStats($this->request->getPost('date'),
                $this->request->getPost('field'));
    }
    
    public function exportcsv()
    {
        $errs = [];
        
        $model = $this->getGetModel();
        if ($model == false) {
            $errs['errors']['request'] = "Invalid Request!";
            return json_encode($errs);
        }
        
        if (empty($model->exportFields)) {
            return json_encode(['errors' => ['request' => 'Unsupported Request!']]);
        }
        
        $this->response->setContentType('application/csv');
        $this->response->setHeader('Content-Disposition', "attachment; filename=".$this->request->getGetPost('model').".csv");
        
        $model->exportCSV($this->getGetParams('orderby', 'id'),$this->getGetParams('order', 'ASC'),
                $this->getGetJsonParam('fields'), $this->getGetParams('search'), $this->getGetJsonParam('filters'), $this->getGetParams('fromdate'),
                $this->getGetParams('todate'));
    }
    
    public function uploadcover()
    {
        $file = $this->request->getFile('cover');
        if ($file !== null) {
            $filename = $file->getRandomName();
            $file->move('assets/covers', $filename);
            return '/assets/covers/'. $filename;
        }
    }
}
