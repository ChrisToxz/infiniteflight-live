<?php

namespace Christoxz\InfiniteflightLive\Http;

use Psr\Http\Message\ResponseInterface;

class Response
{

    private $json;

    private $response;

    private $result;

    public function __construct(ResponseInterface $response)
    {
        $this->setResponse($response);
        $this->decodeJson();
        $this->decodeResult();
    }

    private function setResponse(ResponseInterface $response)
    {
        $this->response = $response;

        return $this;
    }

    private function decodeJson(): self
    {
        $json = json_decode($this->getResponse()->getBody(), true);

        return $this->setJson($json);
    }

    public function getResponse()
    {
        return $this->response;
    }

    private function setJson(mixed $json)
    {
        $this->json = $json;

        return $this;
    }

    private function decodeResult()
    {
        $result = $this->json['result'];

        return $this->setResult($result);
    }

    private function setResult()
    {
        $this->result = $this->json['result'];
    }

    public function getResult()
    {
        return $this->result;
    }

}
