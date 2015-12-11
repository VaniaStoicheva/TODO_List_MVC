<?php

namespace Todo\Repositories;

use Todo\Db;
use Todo\Models\User;

class UserRepository {

    /**
     *
     * @var \Todo\Db
     */
    private $db;

    /**
     *
     * @var UserRepository
     */
    private static $inst = null;

    private function __construct(\Todo\Db $db) {
        $this->db = $db;
    }

    /**
     * 
     * @return UserRepository
     */
    public static function create() {
        if (self::$inst == null) {
            self::$inst = new self(Db::getInstance());
        }
        return self::$inst;
    }

    /**
     * 
     * @param type $id
     * @return boolean
     */
    public function getOneById($id) {
        $query = "SELECT user_id,username,password FROM users WHERE user_id=?";
        $this->db->query($query, array($id));
        $result = $this->db->row();
        if (empty($result)) {
            return false;
        }
        $user = new User(
                $result['username'], $result['password'], $result['user_id']
        );
        return $user;
    }

    /**
     * 
     * @param type $user
     * @param type $pass
     * @return boolean |User
     */
    public function getOneByDetails($user, $pass) {
        $query = "SELECT user_id,username,password FROM users WHERE username=? AND password=?";
        $this->db->query($query, array($user, md5($pass)));
        $result = $this->db->row();
        
        if (empty($result)) {
            return false;
        }

        return $this->getOneById($result['user_id']);
    }

    /**
     * 
     * @return \Todo\Models\User[]
     */
    public function getAll() {
        $query = "SELECT user_id,username,password FROM users";
        $this->db->query($query);
        $result = $this->db->fetchAll();
        $collection = array();
        foreach ($result as $row) {
            $collection = new \Todo\Models\User(
                    $row['username'], $row['password'], $row['user_id']
            );
        }
        return $collection;
    }

    public function save(\Todo\Models\User $user) {
        $query = "INSERT INTO users (`username`,`password`)"
                . "VALUES (?,?)";
        $params = array(
            $user->getUsername(),
            $user->getPassword()
        );
        if ($user->getId()) {
            $query = "UPDATE users SET username=? AND password=? WHERE user_id=?";
            $params[] = $user->getId();
        }
        $this->db->query($query, $params);
        return $this->db->rows();
    }

}
