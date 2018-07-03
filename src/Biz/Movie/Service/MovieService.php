<?php

namespace Biz\Movie\Service;

interface MovieService
{
    public function createMovie($fields);

    public function deleteMovie($id);

    public function getMovie($id);

    public function searchMovies($conditions, $orderBy, $start, $limit);

    public function countMovie($conditions);

    public function updateMovie($id, $fields);
}
