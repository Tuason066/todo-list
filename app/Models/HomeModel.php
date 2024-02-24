<?php

namespace App\Models;

use CodeIgniter\Model;

class HomeModel extends Model
{
  protected $db;
  protected $table = 'task';
  protected $allowedFields = ['name'];

  public function __construct() {
    $this->db = db_connect();
  }

  // CREATE
  public function create($data) {
    $db = db_connect();
    $query = $db->query('INSERT INTO task (name) VALUES (?)', [$data['name']]);
    return $query;
  }

  // FETCH
  public function getTodos() {
    $db = db_connect();
    $query = $db->query('SELECT * FROM task ORDER BY id DESC');
    return $query->getResultArray();
  }

  // FETCH BY ID
  public function getTodoById($todoId) {
    $db = db_connect();
    $todoIdInt = intval($todoId);
    $query = $db->query('SELECT * FROM task WHERE id = ?', [$todoIdInt]);
    return $query->getResultArray();
  }

  // DELETE BY ID
  public function deleteTodoById($id) {
    $db = db_connect();
    $todoIdInt = intval($id);
    $db->query('DELETE FROM task WHERE id = ?', [$todoIdInt]);
  }

  // EDIT BY ID
  public function editTodoById($name, $id) {
    $db = db_connect();
    $todoIdInt = intval($id);
    $db->query('UPDATE task SET name = ? WHERE id = ?', [$name ,$todoIdInt]);
  }
  
}
