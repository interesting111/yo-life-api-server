<?php

namespace Biz\Movie\Service\Impl;

use Biz\Movie\Service\MovieService;
use Biz\BaseService;

class MovieServiceImpl extends BaseService implements MovieService
{
    public function createMovie($fields)
    {
        return $this->getMovieDao()->create($fields);
    }

    public function deleteMovie($id)
    {
        return $this->getMovieDao()->delete($id);
    }

    public function getMovie($id)
    {
        return $this->getMovieDao()->get($id);
    }

    public function searchMovies($conditions, $orderBy, $start, $limit)
    {
        return $this->getMovieDao()->search($conditions, $orderBy, $start, $limit);
    }

    public function countMovie($conditions)
    {
        return $this->getMovieDao()->count($conditions);
    }

    public function updateMovie($id, $fields)
    {
        return $this->getMovieDao()->update($id, $fields);
    }

    protected function getMovieDao()
    {
        return $this->createDao('Movie:MovieDao');
    }
}

