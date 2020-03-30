<?php
    namespace Controller;
    use Controller\AbstractController;
    use Model\User;
    use Core\Validators;

    /**
     * Class UserController
     * @package Controller
     */
    class UserController extends AbstractController
    {

        /**
         * Если авторизован то ищем его данные в БД и возвращаем его
         * профиль, если не авторизован то редирект на страницу входа
         * @throws \Exception
         */
        public function profile()
        {
            if ($this->user->isAuth()){
                $userData = $this->user->findById($this->user->getId());
            } else {
                header("Location: /login");
            }
            return $this->render('profile.php', ['user' => $userData]);
        }

        /**
         * Если получен POST массив то попытка авторизации юзера
         * Eсли пользователь авторизован то редирект на /profile
         * Иначе вывод формы авторизации
         * @see User::loginUser()
         * @see User::isAuth()
         */
        public function login()
        {
            $errors = [];

            if (isset($_POST["_email"])){

                $validate = new Validators();

                if (!$validate->isEmailValid($_POST["_email"])) {
                    $errors []= "Вы ввели неверный email адрес";
                }

                if (empty($errors)) {
                    $userResult = $this->user->find($_POST["_email"]);
                    if (is_array($userResult)) {
                        if (password_verify($_POST["_password"], $userResult['password'])){
                            $this->user->loginUser($userResult['id']);
                            header('Location: /profile');
                        }
                    }

                    $errors []= "Пользователь с таким email не найден или введен неверный пароль";
                }
            }

            if ($this->user->isAuth()){
                header("Location: /profile");
            }
            return $this->render('login.php', ['errors' => $errors, ]);
        }

        /**
         * Попытка деавторизации юзера
         * @see User::logoutUser()
         */
        public function logout()
        {
            $this->user->logoutUser();
            header("Location: /login");
        }

        /**
         * Если получен POST массив то проверяем данные и если данные пройдут валидацию
         * до вызовем add метод. Если валидация не пройдена или POST не получен то просто
         * отобразим форму регистрации
         * @see User::add()
         */
        public function register()
        {
            $errors = [];
            $uploaddir = "/uploads/";
            $photoPath = null;
            $validate = new Validators();

            if (isset($_POST["_email"])){

                $formDate = $_POST["_date_of_birth"];
                $dateOfBirth = ($formDate ? date("Y-m-d H:i:s", strtotime($formDate)) : null);

                if (!$validate->isNameValid($_POST["_name"])) {
                    $errors []= "Поле с именем не заполнено или имя содержит меньше 3 символов";
                }

                if (!$validate->isPasswordValid($_POST["_password"])){
                    $errors []= "Поле с паролем не заполнено или пароль содержит меньше 3 символов";
                }

                if (!$validate->isEmailValid($_POST["_email"])) {
                    $errors []= "Вы ввели неверный email адрес";
                }


                if ($validate->isFileValid($_FILES['_avatar'])) {
                    $tmp_name = $_FILES['_avatar']['tmp_name'];
                    $photoPath = $uploaddir . md5(time()) . "_" . basename($_FILES['_avatar']['name']);
                    move_uploaded_file($tmp_name, $_SERVER["DOCUMENT_ROOT"] . $photoPath);
                }

                if (empty($errors)){
                    $this->user->add([
                        'name' => htmlspecialchars($_POST["_name"]),
                        'email' => $_POST["_email"],
                        'bio' => htmlspecialchars($_POST["_bio"]),
                        'dateOfBirth' => $dateOfBirth,
                        'photoPath' => $photoPath,
                        'password' => $_POST["_password"],
                    ]);
                    header("Location: /login");
                }
            }
            return $this->render('registration.php', ['errors' => $errors, ]);
        }
    }