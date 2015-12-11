<?php

namespace Todo\Repositories;
use Todo\Db;
use Todo\Models\Todo;
class TodoRepository
{
    /**
     *
     * @var \Todo\Db
     */
    private $db;

    /**
     *
     * @var TodoRepository
     */
    private static $inst = null;

    private function __construct(\Todo\Db $db) {
        $this->db = $db;
    }
  /**
     * 
     * @return TodoRepository
     */
    public static function create() {
        if (self::$inst == null) {
            self::$inst = new self(Db::getInstance());
        }
        return self::$inst;
    }
    /**
     * 
     * @param \Todo\Models\Todo $todo
     * @return Todo[]
     */
     public function add($user_id,$todo_item) {
        $query = "INSERT INTO todos (`user_id`,`todo_item`)"
                . "VALUES (?,?)";
        $params = array(
            $user_id,
            $todo_item
        );

        $this->db->query($query, $params);
        return $this->db->rows();
    }
    public function getTodoItem($user_id){
        $query="SELECT * FROM todos WHERE user_id=?";
        $params=array($user_id);
        $this->db->query($query, $params);
        $result=$this->db->fetchAll();
        return $result;

    }
    public function deleteTodoItem($todo_id,$user_id){
        $query="DELETE FROM todos WHERE id=? AND user_id=?";
        $params=array(
            $todo_id,
            $user_id
        );
        $this->db->query($query, $params);
        $result=  $this->db->row()>0;
        if(!$result){
            return FALSE;
        }
        return true;
      
        
                
    }
}