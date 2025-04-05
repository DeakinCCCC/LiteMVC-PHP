<?php
namespace core\Model;

use core\DB\BasePDO;

class BaseModel extends BasePDO
{

    public function __construct($table)
    {
        parent::__construct($table);
    }

}