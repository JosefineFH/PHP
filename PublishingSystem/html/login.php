<?php
require_once('../classes/DBConnection.class.php');

class User extends DBConnection {

    public function check_login($username, $password)
    {
        $sqlStatement = "SELECT * FROM users WHERE username = ? AND password = ?";
        $query = $this->doQuery( $sqlStatement, [$username, $password]);
        return $query;
    }    
}