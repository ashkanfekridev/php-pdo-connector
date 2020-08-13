<?php

namespace Ashkanfekri\dodo;

use \PDO;
use \PDOException;

class PDOConnector
{
  private $host = DB_HOST;
  private $user = DB_USER;
  private $pass = DB_PASS;
  private $dbname = DB_NAME;

  private $connection;
  private $result;
  private $error;

  public function __construct()
  {
    $dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->dbname;

    $options = [
      PDO::ATTR_PERSISTENT => true,
      PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
      PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"
    ];

    try {
      $this->connection = new PDO($dsn, $this->user, $this->pass, $options);

    } catch (PDOException $e) {
      $this->error = $e->getMessage();
      return print_r($e->getMessage());
    }
  }

  /**
   * set query
   * @param $query
   * @return $this
   */
  public function query($query)
  {
    $this->result = $this->connection->prepare($query);
    return $this;
  }

  /**
   * @param $param
   * @param $value
   * @param null $type
   * @return $this
   */
  public function bind($param, $value, $type = null)
  {
    if (is_null($type)) {

      switch (true) {
        case is_int($value):
          $type = PDO::PARAM_INT;
          break;
        case is_bool($value):
          $type = PDO::PARAM_BOOL;
          break;
        case is_null($value):
          $type = PDO::PARAM_NULL;
          break;
        default:
          $type = PDO::PARAM_STR;
      }
    }
    $this->result->bindValue($param, $value, $type);
    return $this;
  }

  /**
   * Fetch a single row as a result of a query.
   * @return mixed
   */
  public function first()
  {
    $this->execute();
    return $this->result->fetch(PDO::FETCH_ASSOC);
  }

  /**
   * Fetch all rows as a result of a query.
   * @return mixed
   */
  public function all()
  {
    $this->execute();
    return $this->result->fetchAll(PDO::FETCH_ASSOC);
  }

  /**
   * @return mixed
   */
  public function count()
  {
    $this->execute();
    return $this->result->rowCount();
  }

  /**
   * execute query
   * @return mixed
   */
  public function execute()
  {
    try {
      return $this->result->execute();
    } catch (PDOException $e) {
      $this->error = $e->getMessage();
    }
  }
}
