<?php
    namespace Model;
    use Config\DB;
    use \DateTime;

    /**
     * Class User
     * Модель пользователя
     * @package Model
     */
    class User
    {
        private $id;

        private $db;

        private $auth;

        public function __construct()
        {
            $this->id = null;
            $this->auth = false;
            $this->db = new DB();
        }

        /**
         * Добавление пользователя
         * @param array $persist
         * @return bool
         */
        public function add(array $persist): bool
        {
            $name = $persist['name'];
            $email = $persist['email'];
            $bio = $persist['bio'];
            $dateOfBirth = $persist['dateOfBirth'];
            $photo = $persist['photoPath'] ?: '';
            $plainPassword = $persist['password'];

            $query = "INSERT INTO `accounts` (name, email, bio, dateOfBirth, photo, password) VALUES (:name, :email, :bio, :dateOfBirth, :photo, :password)";
            $hash = password_hash($plainPassword, PASSWORD_BCRYPT);

            $request = $this->db->connectDB()->prepare($query);

            return $request->execute([
                'name' => $name,
                'email' => $email,
                'bio' => $bio,
                'dateOfBirth' => $dateOfBirth,
                'photo' => $photo,
                'password' => $hash,
            ]);
        }

        /**
         * Поиск пользователя в БД по почте
         * @param $email
         * @return mixed
         */
        public function find(string $email)
        {
            $query = "SELECT * FROM `accounts` WHERE (email = :email)";
            $request = $this->db->connectDB()->prepare($query);
            $request->execute(['email' => $email,]);
            return $request->fetch();
        }

        /**
         * Поиск пользователя в БД по ID
         * @param $id
         * @return mixed
         * @throws \Exception
         */
        public function findById(int $id)
        {
            $query = "SELECT * FROM `accounts` WHERE (id = :id)";

            $request = $this->db->connectDB()->prepare($query);
            $request->execute(['id' => $id,]);
            $result = $request->fetch();

            // если пользователь найден, то подготовим даты
            // сделаем их формата ДД.ММ.ГГГГ
            $dateOfBirth = new DateTime($result['dateOfBirth']);
            $createdDate = new DateTime($result['created']);
            $result['usersYear'] = $this->userYears($dateOfBirth);
            $result['dateOfBirth'] = $dateOfBirth->format('d.m.Y');
            $result['created'] = $createdDate->format('d.m.Y H:i');

            return $result;
        }

        /**
         * Авторизуем пользователя, добавляем его сессию в БД
         * для того чтобы в дальнейшем авторизовывать его в системе (checkAuth найдет его
         * сессию и $this->auth станет true)
         * @param int $id
         * @return bool|null
         */
        public function loginUser(int $id)
        {
            if (session_status() == PHP_SESSION_ACTIVE) {

                $this->id = $id;
                $this->auth = true;

                $query = 'INSERT INTO sessions (id, account_id, login) VALUES (:session, :accountId, NOW())';

                $request = $this->db->connectDB()->prepare($query);
                return $request->execute(['session' => session_id(), 'accountId' => $id, ]);

            }
            return null;
        }

        /**
         * Удаляем запись сессии пользователя из БД
         * тем самым разлогируем пользователя (checkAuth - не найдет его
         * сессию и $this->auth так и останется false)
         * @return null
         */
        public function logoutUser()
        {
            if (session_status() == PHP_SESSION_ACTIVE)
            {
                $query = 'DELETE FROM `sessions` WHERE (id = :sid)';

                $request = $this->db->connectDB()->prepare($query);
                $request->execute(['sid' => session_id()]);
            }
            return null;
        }

        /**
         * Проверка авторизован ли пользователь или нет в
         * зависимости от этого устанавливает свойство $this->auth
         * @return null
         */
        public function checkAuth()
        {
            if (session_status() == PHP_SESSION_ACTIVE) {

                $query = "SELECT * FROM `sessions` as s, `accounts` as a WHERE (s.id = :session) AND (s.login >= (NOW() - INTERVAL 7 DAY)) AND (s.account_id = a.id)";
                $request = $this->db->connectDB()->prepare($query);
                $request->execute(['session' => session_id(),]);
                $result = $request->fetch();

                if (is_array($result)) {
                    $this->id = $result['id'];
                    $this->auth = true;
                }
            }
            return null;
        }

        /**
         * Возвращет возраст пользователя
         * @param DateTime $birthDay
         * @return mixed
         * @throws \Exception
         */
        public function userYears(DateTime $birthDay)
        {
            $yearsInterval = $birthDay->diff(new DateTime(date("Y-m-d")));
            return $yearsInterval->format('%Y');
        }

        /**
         * Возвращает авторизован пользователь или нет
         * @return bool
         */
        public function isAuth(): bool
        {
            return $this->auth;
        }

        /**
         * @return null
         */
        public function getId()
        {
            return $this->id;
        }

    }