<?php

class View
{
    public static function render(
        string $view,
        array $data = [],
        string $layout = 'main',
        
    ): void {

        extract($data);

        $viewPath =
            ROOT_PATH .
            '/resources/views/' .
            $view .
            '.php';

        require ROOT_PATH .
            '/resources/views/layouts/' .
            $layout .
            '.php';
        // require the requested layout first, display the correct view by using $viewPath variable.
    }
}
