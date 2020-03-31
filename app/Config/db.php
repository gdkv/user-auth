<?php
    namespace Config;
    use \PDO;
    use \PDOException;

    /**
     * Class DB
     * Попытка подключения к базе данных
     * @package Config
     */
    class DB
    {
        private $db;

        public function __construct()
        {
            $this->db = null;
        }

        public function connectDB()
        {
            if (is_null($this->db)) {
                $host = getenv('host');
                $port = getenv('port');
                $name = getenv('name');
                $user = getenv('user');
                $password = getenv('password');

                try {
                    $this->db = new PDO("mysql:host={$host};port={$port};dbname={$name}", $user, $password);
                } catch (PDOException $e) {
                    echo "Неудалось подключиться к базе данных\r\n";
                    echo "{$e}\r\n";
                    die();
                }
            }

            return $this->db;
        }
    }