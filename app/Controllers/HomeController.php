<?php

namespace App\Controllers;

use App\Models\HomeModel;


class HomeController extends BaseController
{
    protected $helpers = ['form'];

    public function index(): string
    {
        return view('home');
    }
    
    // create
    public function create() {

        $rules = [
            "todo" => 'required|alpha_numeric_space|is_unique[task.name]' // task.name will point out to the database table and column name
        ];
        
        $data = $this->request->getPost(['todo']); // this will return associative array

        if(! $this->request->is('post')) {
            return view("home");
        }

        if (! $this->validateData($data, $rules)) {

            $data = $this->validator->getErrors(); // this will return associative array
            $error = ['error' => $data['todo']];

            return json_encode($error);
        }

        $homeModel = new HomeModel();
        $homeModel->insert(['name' => $data]);
        $data = $homeModel->getTodos();
        return json_encode($data);
    }

    // get
    public function getTodos() {
        $homeModel = new HomeModel();
        $todos = $homeModel->getTodos();
        return json_encode($todos);
    }

    public function getTodoById($todoId) {
        $id = $todoId;
        $homeModel = new HomeModel();
        $todo = $homeModel->getTodoById($id);
        return json_encode($todo);
    }

    // delete
    public function deleteTodoById($id) {
        $homeModel = new HomeModel();
        $homeModel->deleteTodoById($id);
        $data = $homeModel->getTodos();
        return json_encode($data);
    }

    // update
    public function editTodoById() {
        
        $data = $this->request->getPost();

        $rules = [
            "id" => 'required',
            "name" => 'required|alpha_numeric_space|is_unique[task.name]'
        ];

        if (! $this->validateData($data, $rules)) {
            $errors = $this->validator->getErrors();
            $errorArr = ['error' => $errors['name']];

            return json_encode($errorArr);
        } else {
            $homeModel = new HomeModel();
            $homeModel->editTodoById($data['name'], $data['id']);
            return json_encode($homeModel->getTodos());
        }
        
    }

}
