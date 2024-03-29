<?php

$router->get('', 'ToDoController@read');
$router->post('', 'ToDoController@create');
$router->put('/{id}', 'ToDoController@update'); 
$router->delete('/{id}', 'ToDoController@delete');