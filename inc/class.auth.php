<?php

namespace Inc;

use mysqli;

/**
 * Authentication class with login, status, and logout user
 * 
 * @since 1.0.0
 * @version 1.0.0
 * @author Cak Adi <cakadi190@gmail.com>
 * @package siperpus-simple
 */
class Auth 
{
  /**
   * The DB connection
   * @var \mysqli $db The db connection
   */
  protected static $db;

  /**
   * The Database initialization
   * 
   * @since 1.0.0
   * @author Cak Adi <cakadi190@gmail.com>
   */
  public function __construct($connection)
  {
    session_start();
    self::$db = $connection;
  }

  /**
   * Setting new cookie into cookie and table remember_token
   * 
   * @since 1.0.0
   * @author Cak Adi <cakadi190@gmail.com>
   * @return void
   */
  public static function setRememberToken($email, $token)
  {
    $stmt = self::$db->prepare("UPDATE users SET remember_token = ? WHERE email = ?");
    $stmt->bind_param("ss", $token, $email);
    $stmt->execute();
    $stmt->close();

    // Set the remember token as a cookie
    self::setCookie("remember_token", $token, time() + (86400 * 30)); // Cookie expires in 30 days
  }

  /**
   * Getting user credentials
   * 
   * @since 1.0.0
   * @author Cak Adi <cakadi190@gmail.com>
   * @return \mysql|null|string[] $user
   */
  public static function getUser() 
  {
    // Get Token
    $token = isset($_COOKIE['remember_token']);
    $id    = isset($_COOKIE['user_id']);

    // Retrieve user details from the database
    $stmt = self::$db->prepare("SELECT * FROM users WHERE id = ? OR remember_token = ?");
    $stmt->bind_param("ss", $id, $token);
    $stmt->execute();
    $result = $stmt->get_result();
    $user   = $result->fetch_assoc();
    $stmt->close();

    return $user;
  }

  /**
   * Logout function
   * 
   * @since 1.0.0
   * @author Cak Adi <cakadi190@gmail.com>
   * @return void
   */
  public static function logout()
  {
    self::deleteCookie('remember_token');
    self::deleteCookie('user_id');
    session_destroy();
  }

  /**
   * Authentication action
   * 
   * @return array[]
   * @since 1.0.0
   * @author Cak Adi <cakadi190@gmail.com>
   * @return boolean
   */
  public static function attempt($credentials, $remember = false)
  {
    $stmt = self::$db->prepare("SELECT id, email, password FROM users WHERE email = ?");
    $stmt->bind_param("s", $credentials['email']);
    $stmt->execute();
    $stmt->bind_result($id, $email, $password);
    $stmt->fetch();
    $stmt->close();
    
    if(password_verify($credentials['password'], $password)) {
      // Set the cookie
      if($remember) {
        $token = bin2hex(random_bytes(32));
        self::setRememberToken($email, $token);
      }

      self::setCookie('user_id', $id, time() + 3600);
      return true;
    } else {
      return false;
    }
  }

  private static function setCookie($name, $value, $expiration) {
    setcookie($name, $value, $expiration, "/");
  }

  private static function deleteCookie($name) {
    setcookie($name, "", time() - 3600, "/");
  }
}