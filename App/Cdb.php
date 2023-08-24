<?php
namespace App;

use PDO;

class Cdb {

    protected string $DB_HOST = '127.127.126.47';
    protected string $DB_PORT = '3306';
    protected string $DB_NAME = 'Project-Divia';
    protected string $DB_USER = 'babayka';
    protected string $DB_PASS = 'Another16';
    protected PDO $dbh;

    use SingletonTrait;

    private function __construct() {
        $this->dbh = new \PDO('mysql:host=' . $this->DB_HOST . ';dbname=' . $this->DB_NAME . ';port=' . $this->DB_PORT . ';charset=utf8mb4', $this->DB_USER , $this->DB_PASS);
    }

    public function queryFetch($sql): array|false
    {
        $sth = $this->dbh->prepare($sql);
        $sth->execute();
        return $sth->fetch(\PDO::FETCH_ASSOC);
    }

    public function queryFetchAll($sql, $params = []): array|false
    {
        $sth = $this->dbh->prepare($sql);
        $sth->execute($params);
        return $sth->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function insert($name_table, $data): void
    {
        $array_keys = array_keys($data);
        $keys =  ':' . implode(',:',  $array_keys);
        $sql = "INSERT INTO $name_table (" . implode(',', $array_keys) . ") VALUES ($keys)";
        $sth = $this->dbh->prepare($sql);
        $sth->execute($data);
    }

    public function update($name_table, $data): void
    {
        $array_keys = array_keys($data);
        $keys =  ':' . implode(',:',  $array_keys);

        $sql = "INSERT INTO $name_table (" . implode(',', $array_keys) . ") VALUES ($keys)";

        $sth = $this->dbh->prepare($sql);
        $sth->execute($data);
    }

    public function delete( $name_table, $data): void
    {
        $KeyArray = [];
        foreach (array_keys($data) as $key) {
            $KeyArray[] .= $key . '=:' . $key;
        }
        $sql = "DELETE FROM $name_table WHERE " . implode(' AND ', $KeyArray);
        $sth = $this->dbh->prepare($sql);
        $sth->execute($data);
    }

    function transact(array $arraySql): void
    {
        try {
            $sth = $this->dbh;
            $sth->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sth->beginTransaction();
            foreach ($arraySql as $value) {
                $sth->exec($value);
            }
            $sth->commit();
        } catch (\Exception $e) {
            $sth->rollBack();
            echo "Error MySQL: " . $e->getMessage();
            die;
        }
    }



    //https://phpdelusions.net/pdo/fetch_modes#FETCH_OBJ
    public function query($sql, $params = []): array|false
    {
        $sth = $this->dbh->prepare($sql);
        $sth->execute($params);
        return $sth->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function execute($sql, $params): bool //Переписать под insert
    {
        $sth = $this->dbh->prepare($sql);
        return $sth->execute($params);
    }

}


