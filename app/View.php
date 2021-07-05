<?php


namespace App;


use App\Exceptions\ViewNotFoundException;

class View
{
    public function __construct(private string $view, public array $params = [])
    {
    }

    public static function make(string $view, array $params = []): self
    {
        return new self($view, $params);
    }

    /**
     * @throws ViewNotFoundException
     */
    public function render(): string
    {
        $_viewPath = VIEW_PATH.'/'.$this->view.'.php';
        if (!file_exists($_viewPath)) {
            throw new ViewNotFoundException();
        }
        //making parameters available as variables in view
        extract($this->params);

        ob_start();
        include $_viewPath;
        return (string)ob_get_clean();
    }

    /**
     * @throws ViewNotFoundException
     */
    public function __toString(): string
    {
        return $this->render();
    }
}