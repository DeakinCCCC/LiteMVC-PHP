<?php
namespace core\Model;

use core\DB\BasePDO;

class BaseModel extends BasePDO
{

    protected $table;

    public function __construct($table)
    {
        $config = getMysqlConfig();
        parent::__construct($config['host'].":".$config['port'],$config['dbname']), $config['username'], $config['password']);
        $this->$table = $table;
    }

}