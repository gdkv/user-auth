<?php
    namespace Core;

    /**
     * Class Validators
     * Класс валидации полей
     * @package Core
     */
    class Validators
    {
        /**
         * @param string $name
         * @return bool
         */
        public function isNameValid(string $name): bool
        {
            $valid = true;

            $len = mb_strlen($name);

            if ($len < 3) {
                $valid = false;
            }

            return $valid;
        }

        /**
         * @param string $email
         * @return bool
         */
        public function isEmailValid(string $email): bool
        {
            $valid = true;

            if (filter_var($email, FILTER_VALIDATE_EMAIL) === false){
                $valid = false;
            }

            return $valid;
        }

        /**
         * @param string $password
         * @return bool
         */
        public function isPasswordValid(string $password): bool
        {
            $valid = true;

            $len = mb_strlen($password);

            if ($len < 3) {
                $valid = false;
            }

            return $valid;
        }

        /**
         * @param $file
         * @return bool
         */
        public function isFileValid($file): bool
        {
            $valid = true;

            $format = pathinfo($file['name'], PATHINFO_EXTENSION);
            $is_good = in_array(strtolower($format), ['gif', 'jpg', 'jpeg', 'png']);

            if (!is_uploaded_file($file['tmp_name'])) {
                $valid = false;
            }
            if ($file['size'] > 2000000) {
                $valid = false;
            }
            if (!$is_good) {
                $valid = false;
            }

            return $valid;
        }
    }