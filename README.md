<img src='https://hb.bizmrg.com/gdkv/%D0%A1%D0%BD%D0%B8%D0%BC%D0%BE%D0%BA%20%D1%8D%D0%BA%D1%80%D0%B0%D0%BD%D0%B0%202020-03-31%20%D0%B2%2015.16.34.png' width="800"/>

## Мини приложение авторизации, регистрации пользователя на чистом PHP

#### Установка

Копируем файл с настройками окружения и вносим изменения если необходимо

```bash
cd app/
cp config.example.php config.php
```

Запускаем приложение 

```
make up
```

#### Описание файла с настройками

```php
[
    'debug' => false, # режим отладки (вывод ошибок)
    'host' => 'mysql-container', # хост БД
    'port' => '3306', # порт MySQL
    'name' => 'users_auth', # имя БД
    'user' => 'authuser', # имя пользователя БД
    'password' => 'passAuth123', # пароль БД
];
```

#### Live preview

https://auth.epictest.dev

Данные для входа
```
email: support@epictest.dev
пароль: 12345
```