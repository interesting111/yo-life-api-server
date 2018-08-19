<?php

namespace Component;

use \GuzzleHttp\Client;
use \GuzzleHttp\Exception\ClientException;
use \GuzzleHttp\Exception\ServerException;

class GuzzleServiceProvider
{
    protected $client;

    protected $ci;

    public function __construct($ci)
    {
        $this->client = new Client();

        $this->ci = $ci;
    }

    public function request($method, $url, array $args = [], array $headers = [])
    {
        try {
            switch ($method) {
                case 'GET':
                    return $this->get($url, $args, $headers);
                break;
            }
        } catch (ClientException $e) {
            $this->getLogger()->addError('Client Exception', $args);

            return [
                'code' => $e->getResponse()->getStatusCode(),
                'body' => [],
            ];
        } catch (ServerException $e) {
            $this->getLogger()->addError('Server Exception', $args);

            return [
                'code' => $e->getResponse()->getStatusCode(),
                'body' => [],
            ];
        }
    }

    private function get($url, $args, $headers)
    {
        $params = [];

        if (!empty($args)) {
            $params['query'] = $args;
        }

        if (!empty($headers)) {
            $params['headers'] = $headers;
        }

        $response = $this->client->request('GET', $url, $params);

        return [
            'code' => $response->getStatusCode(),
            'body' => json_decode($response->getBody()->getContents(), true),
        ];
    }

    protected function getLogger()
    {
        return $this->ci['logger'];
    }
}
