<?php

namespace Controller;

use Controller\BaseController;

class MovieController extends BaseController
{
    use ControllerTrait;

    public function get($request, $response, $args)
    {
        $movie = $this->getMovieSerivce()->getMovie($args['id']);

        return $response->withJson($this->createSuccessResponse($movie));
    }

    public function list($request, $response, $args)
    {
        $params = $request->getQueryParams();

        $conditions = $this->conditions($params);

        $count = $this->getMovieSerivce()->countMovie($conditions);

        $paginator = $this->paginator($count, $params['offset'], $params['limit']);

        $movies = $this->getMovieSerivce()->searchMovies(
            $conditions,
            array('createdTime' => 'DESC'),
            $paginator->offset,
            $paginator->limit
        );

        return $response->withJson($this->createSuccessResponse($movies));
    }

    protected function getMovieSerivce()
    {
        return $this->createService('Movie:MovieService');
    }
}
