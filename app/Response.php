<?php


namespace App;


class Response
{
    use FactoryMethod;

    private string $version;
    private string $message;
    private int $code;
    private array $data;

    public function __construct()
    {
    }

    public function setCode(int $code): self
    {
        $this->code = $code;
        return $this;
    }

    public function setData(array $data): self
    {
        $this->data = $data;
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

    public function setHeader(string $header): self
    {
        header($header);
        return $this;
    }

    public function buildHeader(): void
    {
        header($this->version ?? 'HTTP/1.1' . ' ' . $this->code . ' ' . $this->message);
    }

    public function __toString(): string
    {
        return json_encode($this->data);
    }
}