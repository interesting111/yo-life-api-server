<?php

$app->get('/movie', '\Controller\MovieController:list');

$app->get('/movie/{id}', '\Controller\MovieController:get');

//example
// $app->post('/movie', '\Controller\MovieController:create');

// $app->put('/movie/{id}', '\Controller\MovieController:update');

// $app->delete('/movie/{id}', '\Controller\MovieController:delete');