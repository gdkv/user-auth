<?php
    use Controller\UserController;

    /**
     * Class Router
     * Получение запроса, обработка его и
     * выдача нужного контроллера
     */
    class Router
    {

        /**
         * @var mixed
         */
        private $url;

        /**
         * массив c action и переменными полученными
         * из url
         * @var array
         */
        private $request;

        public function __construct()
        {
            $this->url = $_SERVER["REQUEST_URI"];
            $this->request = [];
        }

        /**
         * Вызывает нужный контроллер если он существует
         * иначе метод notFound
         */
        public function forward()
        {
            $this->detect();
            $controller = new UserController();
            if (method_exists($controller, $this->request['action'])) {
                call_user_func_array([$controller, $this->request['action']], $this->request['params']);
            } else {
                call_user_func_array([$controller, 'notFound'], []);
            }
        }

        /**
         * Метод проверяет не пустой ли URL и если нет то
         * разбивает его на части выделяет из него контроллер и параметры
         * Если URL пустой или просто / то добавляем в него контроллер по-умолчанию
         */
        private function detect()
        {
            $this->url = trim($this->url);

            if (empty($this->url) || $this->url == "/"){
                // start page request
                // set up default values
                $this->request['action'] = "login";
                $this->request['params'] = [];
            } else {
                // explode url by slash sign
                $explode_url = explode('/', $this->url);
                $explode_url = array_slice($explode_url, 1);

                $this->request['action'] = $explode_url[0];

                // get all elements from 1 to end,
                // and put it to params
                $this->request['params'] = array_slice($explode_url, 1);
            }

        }

    }