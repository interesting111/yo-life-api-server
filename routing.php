<?php

$app->get('/movie', '\Controller\MovieController:list');

$app->get('/movie/{id}', '\Controller\MovieController:get');

$app->get('/login', '\Controller\LoginController:index')->setName('login');
//example
// $app->post('/movie', '\Controller\MovieController:create');

// $app->put('/movie/{id}', '\Controller\MovieController:update');

// $app->delete('/movie/{id}', '\Controller\MovieController:delete');