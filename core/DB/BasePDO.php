<?php
namespace core\DB;

class BasePDO
{
    private $pdo;  // pdo对象

    public function __construct($host, $dbname, $username, $password)
    {
        $dsn = "mysql:host=$host;dbname=$dbname;charset=utf8mb4";
        $options = array(
            \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
            \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
        );
        $this->pdo = new \PDO($dsn, $username, $password, $options);
    }

    public function query($sql, $params = [])
    {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    }

    public function fetchAll($sql, $params = [])
    {
        $stmt = $this->query($sql, $params);
        return $stmt->fetchAll();
    }

    public function fetch($sql, $params = [])
    {
        $stmt = $this->query($sql, $params);
        return $stmt->fetch();
    }

    public function insert($table, $data)
    {
        $columns = implode(', ', array_keys($data));
        $values = ':' . implode(', :', array_keys($data));
        $sql = "INSERT INTO $table ($columns) VALUES ($values)";
        $this->query($sql, $data);
    }

    public function update($table, $data, $where = [])
    {
        $set = '';
        foreach ($data as $key => $value) {
            $set .= "$key = :$key, ";
        }
        $set = rtrim($set, ', ');
        $whereClause = '';
        foreach ($where as $key => $value) {
            $whereClause .= "$key = :$key AND ";
        }
        $whereClause = rtrim($whereClause, ' AND ');
        $sql = "UPDATE $table SET $set WHERE $whereClause";
        $this->query($sql, array_merge($data, $where));
    }

    public function delete($table, $where)
    {
        $whereClause = '';
        foreach ($where as $key => $value) {
            $whereClause .= "$key = :$key AND ";
        }
        $whereClause = rtrim($whereClause, ' AND ');
        $sql = "DELETE FROM $table WHERE $whereClause";
        $this->query($sql, $where);
    }
}