<?php
namespace App\Models;

use Rahisi\RahisiDb\table;

class test extends table
{
    
    public $table = 'test';

    public function __construct()
    {
        new table($this->table);
    }

    public function find($id)
    {
        return $this->where(["id"=> $id])->get()[0];
    }
}