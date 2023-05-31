<?php

namespace Inc;

use mysqli;

/**
 * The class for database connection initialization
 * 
 * @since 1.0.0
 * @version 1.0.0
 * @author Cak Adi <cakadi190@gmail.com>
 * @package siperpus-simple
 */
class DBConnection
{
  /**
   * Connection result
   * @var \mysqli|null $connection The connection result
   */
  protected $connection;

  /**
   * Preparing DB Connection
   * 
   * @since 1.0.0
   * @author Cak Adi <cakadi190@gmail.com>
   */
  public function __construct($hostname, $username, $password, $database, $port = 3306)
  {
    $this->connection = new mysqli($hostname, $username, $password, $database, $port)
      or die("Sorry, the database cannot connect seamlessly.");
  }

  /**
   * Getting current connection
   * 
   * @return \mysqli $connection
   * @since 1.0.0
   * @version 1.0.0
   * @author Cak Adi <cakadi190@gmail.com>
   */
  public function getConnection()
  {
    return $this->connection;
  }

  /**
   * The insertion query
   * 
   * @since 1.0.0
   * @version 1.0.0
   * @author Cak Adi <cakadi190@gmail.com>
   * @param string $table The table name to insert data
   * @param string[] $data the data with key column to insert it
   */
  public function insert($table, $data)
  {
    // Prepare table first
    $columns      = implode(", ", array_keys($data));
    $placeholders = implode(", ", array_fill(0, count($data), "?"));
    $values       = array_values($data);

    // Insert Query
    $stmt = $this->connection->prepare("INSERT INTO $table ($columns) VALUES ($placeholders)");
    $stmt->bind_param(str_repeat("s", count($values)), ...$values);

    // Run and check if is successfully inserted or not
    if ($stmt->execute()) {
      return true;
    } else {
      return "Error inserting data: " . $stmt->error;
    }

    // Don't forget Close connection
    $stmt->close();
  }

  /**
   * The update query
   *
   * @author Cak Adi <cakadi190@gmail.com>
   * @since 1.0.0
   * @version 1.0.0
   * @param string $table The table name to update data
   * @param string[] $data The data with key column to update
   * @param string $condition The condition for the update query
   */
  public function update($table, $data, $condition)
  {
    // Prepare the SET clause
    $setClause = "";
    foreach ($data as $column => $value) {
      $setClause .= "$column = ?, ";
    }
    $setClause = rtrim($setClause, ", ");

    // Prepare the UPDATE query
    $stmt = $this->connection->prepare("UPDATE $table SET $setClause WHERE $condition");

    // Bind the values
    $types = str_repeat("s", count($data));
    $values = array_values($data);
    $stmt->bind_param($types, ...$values);

    // Run and check if the update was successful or not
    if ($stmt->execute()) {
      return true;
    } else {
      return "Error inserting data: " . $stmt->error;
    }

    // Close the statement
    $stmt->close();
  }
}
