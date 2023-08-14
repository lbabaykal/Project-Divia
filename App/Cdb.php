<?php
namespace App;

use PDO;

class Cdb {

    protected string $DB_HOST = '127.127.126.47';
    protected string $DB_NAME = 'Project-Divia';
    protected string $DB_USER = 'babayka';
    protected string $DB_PASS = 'Another16';
    protected PDO $dbh;

    public function __construct() {
        $this->dbh = new \PDO('mysql:host=' . $this->DB_HOST . ';dbname=' . $this->DB_NAME . ';charset=utf8mb4', $this->DB_USER , $this->DB_PASS);
    }

    public function query($sql, $class, $params = []): array
    {
        $sth = $this->dbh->prepare($sql);
        $sth->execute($params);
        return $sth->fetchAll(\PDO::FETCH_CLASS, $class);
    }

    public function execute($sql, $params): bool //Переписать под insert
    {
        $sth = $this->dbh->prepare($sql);
        return $sth->execute($params);
    }

    //$DBH->prepare("INSERT INTO folks (name, addr, city) values (:name, :addr, :city)");
    public function insert( $name_table, $array): void
    {
        $array_keys = array_keys($array);
        $keys =  ':' . implode(',:',  $array_keys);

        $sql = "INSERT INTO $name_table (" . implode(',', $array_keys) . ") VALUES ($keys)";

        $sth = $this->dbh->prepare($sql);
        $sth->execute($array);
    }




    function transact($sql1, $sql2): void
    {
        $sth = $this->dbh;
        $sth->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sth->beginTransaction();
        $sth->exec($sql1);
        $sth->exec($sql2);
        $sth->commit();
    }

    function transact_3($sql1, $sql2, $sql3): void
    {
        $sth = $this->dbh;
        $sth->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sth->beginTransaction();
        $sth->exec($sql1);
        $sth->exec($sql2);
        $sth->exec($sql3);
        $sth->commit();
    }

}


