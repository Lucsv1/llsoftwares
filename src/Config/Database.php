<?php

namespace Admin\Project\Config;

use Exception;
use PDO;
use PDOException;

class Database
{
    private $dsn;
    private $user;
    private $password;

    public function __construct()
    {
        $this->setDsn('mysql:host=127.0.0.1;dbname=projeto_futuro');
        $this->setUser('root');
        $this->setPassword('');
    }

    /**
     * Get the value of dsn
     */
    public function getDsn()
    {
        return $this->dsn;
    }

    /**
     * Set the value of dsn
     *
     * @return  self
     */
    public function setDsn($dsn)
    {
        $this->dsn = $dsn;

        return $this;
    }

    /**
     * Get the value of user
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set the value of user
     *
     * @return  self
     */
    public function setUser($user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get the value of password
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set the value of password
     *
     * @return  self
     */

    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    public function auth_db()
    {
        $dns = $this->getDsn();
        $username = $this->getUser();
        $password = $this->getPassword();

        try {
            $pdo = new PDO($dns, $username);

            
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            $sql_file = __DIR__ . '/tables.sql';
            
            $sql = file_get_contents($sql_file);

            
            if ($sql === false) {
                throw new Exception("Error ao ler sql");
            }
            
            $queries = explode(";", $sql);
            
            

            foreach ($queries as $query) {
                $query = trim($query);
                if ($query) {
                    preg_match('/`([^`]*)`/', $query, $matches);
                    $tablename = $matches[0];
                    if (!$this->tableExists($pdo, $tablename)) {
                        var_dump($this->tableExists($pdo, $tablename));
                        $pdo->exec($query);
                    }
                }
            }

            if(!$this->user_root_exists($pdo)){
                $this->create_root_user($pdo, "admin", '$2y$10$RYsEZHumxHJqsnkkPWxhYe.NtZl8NLNxR3QcobPMD/s8vJNpPvWVO', array("role"=> "admin"), 1 );
            }

            return $pdo;

        } catch (PDOException $e) {
            echo $e;
        }
    }

    private function create_root_user($pdo, $username, $password, $role, $active)
    {
        $sql_create = "INSERT INTO Users (Username, Password, Role, Active) VALUES (:username, :password, :role, :active)";
        $stmt = $pdo->prepare($sql_create);

        $stmt->bindValue(":username", $username);
        $stmt->bindValue(":password", $password);
        $stmt->bindValue(":role", json_encode($role));
        $stmt->bindValue(":active", $active);

        $stmt->execute();
    }

    private function tableExists($pdo, $tablename){

        $tablename = trim($tablename, '`');
        
        try {
            $result = $pdo->query("SELECT 1 FROM $tablename LIMIT 1");
            return $result;
        } catch (PDOException $e) {
            return false;
        }
    }

    private function user_root_exists($pdo){
        try{
            $result = $pdo->query("SELECT Username FROM Users");
            return $result->rowCount() > 0;
        }catch (PDOException $e){
            return false;
        }
    }
}
