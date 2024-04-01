<?php

$router->get('', 'ToDoController@read');
$router->post('', 'ToDoController@create');
$router->put('update/{id}', 'ToDoController@update'); 
$router->delete('delete/{id}', 'ToDoController@delete');