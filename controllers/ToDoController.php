<?php

class ToDoController {
    public function read() {
        $todos = App::get('database')->read('todos');
        header('Content-Type: application/json');
        echo json_encode($todos);
    }
    public function create()
    {
        // Assuming you're receiving JSON data in the request body
        $requestBody = file_get_contents('php://input');
        $data = json_decode($requestBody, true); // Decode JSON data into associative array
        // Check if JSON data is valid
        if ($data !== null) {
            // Assuming $data contains the todo data in JSON format
            App::get('database')->create('todos', [
                'description' => $data['description'], // Assuming 'description' is a field in the JSON data
                'completed' => $data['completed']
            ]);
        } else {
            http_response_code(400);
            echo json_encode(['error' => 'Invalid JSON data']);
        }
    }
    public function update($id) {
        $data = json_decode(file_get_contents('php://input'), true);
        if($data != null){
            App::get('database')->update('todos', [
                'description' => $data['description'], 
                'completed' => $data['completed']
            ], "id = $id");
            echo json_encode(['message' => 'Todo updated successfully']);
        } else {
            http_response_code(400);
            echo json_encode(['error' => 'Invalid JSON data']);
        }
    }

    public function delete($id) {
        App::get('database')->delete('todos', $id);
        header('Content-Type: application/json');
        echo json_encode(['message' => 'Todo deleted successfully']);
    }
}
