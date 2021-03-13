<?php
class Response
{
    protected $content;
    protected $status_code = 200;
    protected $status_text = 'OK';
    protected $http_headers = [];

    public function send()
    {
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Headers: access");
        header("Access-Control-Allow-Credentials: true");
        header("Content-Type: application/json; charset=UTF-8");

    }

    public function setContent($content)
    {
        $this->content = $content;
    }

    public function setStatusCode($status_code, $status_text = '')
    {
        $this->status_code = $status_code;
        $this->status_text = $status_text;
    }


    public function setHttpHeader($name, $value)
    {
        $this->http_headers[$name] = $value;
    }
}
