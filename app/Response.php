<?php


namespace App;


class Response
{

    private string $version;
    private string $message;
    private int $code;

    public function __construct()
    {
    }

    public static function make(): self
    {
        return new self();
    }

    public function setCode(int $code): self
    {
        $this->code = $code;
        return $this;
    }

    public function setResponseCode(int $code = 200): void
    {
        http_response_code($code);
    }

    public function setHTTPVersion(string $version): self
    {
        $this->version = $version;
        return $this;
    }

    public function setMessage(string $message = 'Success'): self
    {
        $this->message = $message;
        return $this;
    }

    public function setHeader(string $header): void
    {
        header($header);
    }

    public function buildHeader(): void
    {
        header($this->version ?? 'HTTP/1.1'.' '.$this->code.' '.$this->message);
    }
}