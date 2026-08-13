 <?php
    // declare(strict_types=1);
    class Router
    {
        private array $routes = ['login' => ''];

        public function get(string $uri, array $controller, array $middlewares = []): void
        {

            $this->addRoute('GET', $uri, $controller, $middlewares);
        }

        public function post(string $uri, array $controller, array $middlewares = []): void
        {
            $this->addRoute('POST', $uri, $controller, $middlewares);
        }

        private function addRoute(
            string $method,
            string $uri,
            array $controller,
            array $middlewares = []
        ): void {

            $this->routes[$method][] = [

                'uri' => $uri,

                'controller' => $controller[0],

                'action' => $controller[1],

                'middlewares' => $middlewares
            ]; // add this element to the end of the array
        }

        public function dispatch(): void
        {
            $requestMethod = $_SERVER['REQUEST_METHOD'];

            $requestUri = parse_url(
                $_SERVER['REQUEST_URI'],
                PHP_URL_PATH
            );

            // $base = '/moms/public';
            $base = '';

            if (str_starts_with($requestUri, $base)) {
                $requestUri = substr($requestUri, strlen($base));
            }

            if ($requestUri === '') {
                $requestUri = '/';
            }

            foreach ($this->routes[$requestMethod] ?? [] as $route) {

                $pattern = preg_replace(
                    '#\{([^}]+)\}#',
                    '([^/]+)',
                    $route['uri']
                );

                $pattern = '#^' . $pattern . '$#';

                if (preg_match($pattern, $requestUri, $matches)) {
                    array_shift($matches);

                    foreach ($route['middlewares'] as $middleware) {

                        // Middleware without parameters
                        if (is_string($middleware)) {
                            (new $middleware())->handle();
                            continue;
                        }
                        // Middleware with parameters
                        [$class, $params] = $middleware;

                        (new $class())->handle(...$params);
                    }

                    $controllerName = $route['controller'];
                    $controller = new $controllerName();

                    $action = $route['action'];

                    $parameters = array_map(
                        function (string $value): string|int {
                            return ctype_digit($value)
                                ? (int) $value
                                : $value;
                        },
                        $matches
                    );

                    $controller->$action(...$parameters);

                    return;
                }
            }

            http_response_code(404);

            require ROOT_PATH .
                '/resources/views/errors/404.php';
        }
    }
