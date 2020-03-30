<?php
    namespace Controller;
    use Model\User;

    /**
     * Class AbstractController
     * Общий класс контроллеров, содержит методы которые понадобятся
     * абсолютно всем контроллерам - рендер страницы, 404 ошибка
     * а так же подготавливает свойство user в котором содержится авторизован
     * пользователь и его ID
     * @package Controller
     */
    class AbstractController
    {
        public $user;


        public function __construct()
        {
            $this->user = new User();
            $this->user->checkAuth();

        }

        public function notFound()
        {
            header("HTTP/1.0 404 Not Found");
            echo "404. Page Not Found";
        }

        /**
         * Рендер страницы, получаем имя шаблона и массив переменных
         * делаем распаковку переменных, кладем нужный макет в $content и делаем вызов
         * базового шаблона
         * @param $template
         * @param $params
         */
        public function render($template, $params)
        {
            extract($params);
            ob_start();
            require("../Views/" . $template);
            $content = ob_get_clean();
            require("../Views/base.php");
        }
    }