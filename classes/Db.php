<?php

namespace app\classes;

use PDO;

class Db
{
    private string $user;
    private string $pass;
    private string $driver;
    private string $database;
    private string $host;
    private string $charset;

    /**
     * @var PDO|null
     */
    protected ?PDO $connect = null;

    public function __construct($user, $pass, $database, $driver = 'mysql', $host = 'localhost', $charset = 'UTF8')
    {
        $this->user = $user;
        $this->pass = $pass;
        $this->database = $database;
        $this->driver = $driver;
        $this->host = $host;
        $this->charset = $charset;
    }

    /**
     * @return PDO|null
     */
    protected function getConnect(): ?PDO
    {
        if (empty($this->connect)) {
            $this->connect = new PDO(
                $this->getDSN(),
                $this->user,
                $this->pass
            );


            $this->connect->setAttribute(
                PDO::ATTR_DEFAULT_FETCH_MODE,
                PDO::FETCH_OBJ
            );
        }
        return $this->connect;
    }

    /**
     * @return string
     */
    private function getDSN(): string
    {
        return sprintf(
            '%s:host=%s;dbname=%s;charset=%s',
            $this->driver,
            $this->host,
            $this->database,
            $this->charset
        );
    }

    /**
     * @param string $sql
     * @param array $params
     * @return false|\PDOStatement
     */
    private function query(string $sql, array $params = [])
    {
        $PDOStatement = $this->getConnect()->prepare($sql);
        $PDOStatement->execute($params);
        return $PDOStatement;
    }

    /**
     * @param string $sql
     * @param string $class
     * @param array $params
     * @return mixed
     */
    public function findObject(string $sql, string $class, array $params = [])
    {
        $PDOStatement = $this->query($sql, $params);
        $PDOStatement->setFetchMode(
            PDO::FETCH_CLASS,
            $class
        );
        return $PDOStatement->fetch();
    }

    /**
     * @param string $sql
     * @param array $params
     * @return bool
     */
    public function execute(string $sql, array $params = [])
    {
        return $this->query($sql, $params);
    }
}