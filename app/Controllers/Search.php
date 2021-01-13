<?php

namespace App\Controllers;

/**
 * Description of newfunc
 *
 * @author tetrex
 */
class Search extends BaseController
{
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
    
    public function index()
    {
        $books = model('BooksModel');
        $res = $books->getEntries(0, 20, 'name', 'ASC', ['name','author', 'genre', 
            'category', 'edition', 'isbn', 'publ', 'desc', 'sec'], $this->request->getPost('text'));
        
        if ($res !== null) {
            return $this->traverseJson($res);
        } else {
            return json_encode(['errors' => ['database' => $books->errors() ]]);
        }
    }
}
