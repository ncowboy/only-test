<?php

namespace app\classes;

use PDO;

class Db
{
    private $user;
    private $pass;
    private $driver;
    private $database;
    private $host;
    private $charset;

    /**
     * @var PDO|null
     */
    protected $connect = null;

    public function __construct($user, $pass, $database, $driver = 'mysql', $host = 'localhost', $charset = 'UTF8')
    {
        $this->user = $user;
        $this->pass = $pass;
        $this->database = $database;
        $this->driver = $driver;
        $this->host = $host;
        $this->charset = $charset;
    }

    protected function getConnect()
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
     * Создание строки - настройки для подключения
     * @return string
     */
    private function getDSN()
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
     * Выполнение запроса
     *
     * @param string $sql 'SELECT * FROM users WHERE id = :id'
     * @param array $params [':id' => 123]
     */
    private function query(string $sql, array $params = [])
    {
        $PDOStatement = $this->getConnect()->prepare($sql);
        $PDOStatement->execute($params);
        return $PDOStatement;
    }

    /**
     * @param string $sql
     * @param array $params
     * @return mixed
     */
    public function find(string $sql, array $params = [])
    {
        return $this->query($sql, $params)->fetch();
    }

    public function findObject(string $sql, $class, array $params = [])
    {
        $PDOStatement = $this->query($sql, $params);
        $PDOStatement->setFetchMode(
            PDO::FETCH_CLASS,
            $class
        );
        return $PDOStatement->fetch();
    }

    /**
     * Получение всех строк
     *
     * @param string $sql
     * @param array $params
     * @return mixed
     */
    public function findAll(string $sql, array $params = [])
    {
        return $this->query($sql, $params)->fetchAll();
    }

    /**
     * Выполнение безответного запроса
     *
     * @param string $sql
     * @param array $params
     * @return bool
     */
    public function execute(string $sql, array $params = [])
    {
        return $this->query($sql, $params);
    }
}