<?php

namespace app\models;

use core\Model\BaseModel;

class demoModel extends BaseModel
{
    public function __construct()
    {
        parent::__construct("demo");
    }

    public function test(){

        return $this->fetchAll("SELECT * FROM `demo`");

    }
}