<?php
    // стартуем сессию для авторизации/аутентификации
    session_start();

    // грузим необходимые для работы файлы
    require('../Config/core.php');
    require('../router.php');

    use Config\Env;

    // читаем файл с конфигурацией
    $env = new Env();
    $env->load();

    // проверка на режим отладки
    $isDebug = getenv('debug');
    error_reporting(E_ALL & ~E_NOTICE);
    ini_set('display_errors', (int)$isDebug);

    // ловим запрос и отдаем пользователю нужное отображение
    $router = new Router();
    $router->forward();

