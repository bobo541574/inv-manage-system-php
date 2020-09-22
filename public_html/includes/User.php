<?php

class User
{
    private $con;

    public function __construct()
    {
        include_once('../database/Database.php');

        $db = new Database();
        $this->con = $db->connect();
    }

    /* To check, user is already registered or not. */
    private function emailExistS($email)
    {
        $stmt = $this->con->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute() or die($this->con->error);
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            return 1;
        } else {
            return 0;
        }
    }

    private function confirmPassword($password, $confirm_password)
    {
        return $password === $confirm_password ? 1 : 0;
    }

    public function createUser($username, $email, $password, $confirm_password, $user_type)
    {
        if ($this->emailExistS($email)) {
            return "EMAIL_ALREADY_EXISTS";
        } else {

            if ($this->confirmPassword($password, $confirm_password)) {
                $password = password_hash($password, PASSWORD_BCRYPT, ["secret" => 8]);
                $date = date("Y-m-d h:i:s");
                $note = "";
                $stmt = $this->con->prepare("INSERT INTO `users` (`username`, `email`, `password`, `user_type`, `register_date`, `last_login`, `note`) 
                                            VALUES(?, ?, ?, ?, ?, ?, ?)");
                $stmt->bind_param("sssssss", $username, $email, $password, $user_type, $date, $date, $note);
                $result = $stmt->execute() or die($this->con->error);

                if ($result) {
                    return $this->con->insert_id;
                } else {
                    return "SOME_ERROR";
                }
            } else {
                return "PASSWORD_NOT_MATCHED";
            }
        }
    }

    public function loginUser($email, $password)
    {
        $stmt = $this->con->prepare("SELECT id, username, email, password, last_login FROM users WHERE `email` = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute() or die($this->con->error);
        $result = $stmt->get_result();

        if ($result->num_rows < 1) {
            return "NOT_REGISTERED";
        } else {
            $row = $result->fetch_assoc();
            if (password_verify($password, $row['password'])) {
                $data = date("Y-m-d h:i:s");

                $stmt = $this->con->prepare("UPDATE users SET `last_login` = ? WHERE `email` = ?");
                $stmt->bind_param("ss", $data, $email);
                $result = $stmt->execute() or die($this->con->error);

                if ($result) {
                    $_SESSION["id"] = $row["id"];
                    $_SESSION["username"] = $row["username"];
                    $_SESSION["last_login"] = $row["last_login"];
                    return 1;
                } else {
                    return 0;
                }
            } else {
                return "PASSWORD_NOT_MATCHED";
            }
        }
    }
}

// $user = new User();
// echo $user->createUser("Bo Bo", "bobo1@gmail.com", "password", "password", "1");
// echo $user->userLogin("bobo@gmail.com", "password");