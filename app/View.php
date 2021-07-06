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

    public function with(array $params = []): self
    {
        $this->params = array_merge($this->params, $params);
        return $this;
    }

    /**
     * @throws ViewNotFoundException
     */
    public function render(): string
    {
        $_viewPath = Application::VIEW_PATH.'/'.$this->view.'.php';
        if (!file_exists($_viewPath)) {
            throw new ViewNotFoundException();
        }
        //making parameters available as variables in view
        extract($this->params);

        ob_start();
        include $_viewPath;
        $layout = $view = ob_get_clean();
        if (str_contains($view, '@layout')) {
            $path = $this->get_string_between($view, '@layout(', ')');
            $path = rtrim($path, "'");
            $path = rtrim($path, '"');
            $path = ltrim($path, "'");
            $path = ltrim($path, "'");
            $title = $this->get_string_between($view, '@title', '@endtitle');
            $content = $this->get_string_between($view, '@content', '@endcontent');
            ob_start();
            include Application::VIEW_PATH.'/layout/'.$path.'.php';;
            $layout = ob_get_clean();
            $layout = str_replace('{{content}}', $content, $layout);
            $layout = str_replace('{{title}}', $title, $layout);
        }
        return $layout;
    }

    /**
     * @throws ViewNotFoundException
     */
    public function __toString(): string
    {
        return $this->render();
    }

    private function get_string_between($string, $start, $end): string
    {
        $string = ' '.$string;
        $ini = strpos($string, $start);
        if ($ini == 0) {
            return '';
        }
        $ini += strlen($start);
        $len = strpos($string, $end, $ini) - $ini;
        return substr($string, $ini, $len);
    }
}