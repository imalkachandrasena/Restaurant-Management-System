<?php


class App {

    public $host = HOST;
    public $dbname = DBNAME;
    public $user = USER;
    public $pass = PASS;

    public $link;



    //create a construct

    public function __construct() {

        $this->connect();
    }


    public function connect() {
        $this->link = new PDO("mysql:host=".$this->host.";dbname=".$this->dbname."", $this->user, $this->pass);
    }


    //select all
    public function selectAll($query) {

        $rows = $this->link->query($query);
        $rows->execute();

        $allRows = $rows->fetchAll(PDO::FETCH_OBJ);

        if($allRows) {
            return $allRows;
        } else {
            return [];
        }
    }

    //select one row
    public function selectOne($query) {

        $row = $this->link->query($query);
        $row->execute();

        $singleRow = $row->fetch(PDO::FETCH_OBJ);

        if($singleRow) {
            return $singleRow;
        } else {
            return false;
        }

    }

    public function validateCart($q) {
        $row = $this->link->query($q);
        $row->execute();
        $count = $row->rowCount();
        return $count;
    }

    //insert query
    public function insert($query, $arr, $path) {

        if($this->validate($arr) == "empty") {
            echo "<script>alert('one or more inputs are empty')</script>";
        } else {

            $insert_record = $this->link->prepare($query);
            $insert_record->execute($arr);

            echo "<script>window.location.href='".$path."'</script>";
        }
    }

    //update query
    public function update($query, $arr, $path) {

        if($this->validate($arr) == "empty") {
            echo "<script>alert('one or more inputs are empty')</script>";
        } else {

            $update_record = $this->link->prepare($query);
            $update_record->execute($arr);

            header("location: ".$path."");
        }
    }


    //delete query
    public function delete($query, $path) {

        $delete_record = $this->link->query($query);
        $delete_record->execute();

        echo "<script>window.location.href='".$path."'</script>";

    }

    public function validate($arr) {
        if(in_array("", $arr)) {
            echo "empty";
        }
    }


    public function register($query, $arr, $path) {

        if($this->validate($arr) == "empty") {
            echo "<script>alert('one or more inputs are empty')</script>";
        }
        else {

            $register_user = $this->link->prepare($query);
            $register_user->execute($arr);

            header("location: ".$path."");
        }
    }

    public function login($query, $data, $path) {

        //email
        $login_user = $this->link->query($query);
        $login_user->execute();

        $fetch = $login_user->fetch(PDO::FETCH_ASSOC);

        if($login_user->rowCount() > 0) {

            //password
            if(password_verify($data['password'], $fetch['password'])) {
                //start session vars
                $_SESSION['email'] = $fetch['email'];
                $_SESSION['username'] = $fetch['username'];
                $_SESSION['user_id'] = $fetch['id'];

                header("location: ".$path."");
            }
        }else{
            $_SESSION['userNotFound'] = "User can not found";
            return $_SESSION['userNotFound'];
        }

    }

    public function loginAdmin($query, $data, $path) {

            //email
            $login_user = $this->link->query($query);
            $login_user->execute();

            $fetch = $login_user->fetch(PDO::FETCH_ASSOC);

            if($login_user->rowCount() > 0) {

                //password
                if(password_verify($data['password'], $fetch['password'])) {
                    //start session vars
                    $_SESSION['admin_email'] = $fetch['email'];
                    $_SESSION['admin_username'] = $fetch['username'];
                    $_SESSION['admin_user_id'] = $fetch['id'];

                    header("location: ".$path."");
                }
            }else{
                echo "<script>alert('Can not find any kind of user!')</script>";
            }
    }

    //starting session
    public function startingSession() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    //session for admin
    public function startingSessionAdmin(){
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }


    //validating sessions
    public function validateSession() {
        if(isset($_SESSION['user_id'])) {
            echo "<script>window.location.href='".APPURL."'</script>";
        }
    }

    public function validateSessionAdmin() {
        if(isset($_SESSION['admin_email'])) {
            echo "<script>window.location.href='".ADMINURL."/index.php'</script>";
        }
    }

    public function validateSessionAdminInside() {
        if(!isset($_SESSION['admin_email'])) {
            echo "<script>window.location.href='".ADMINURL."/admins/login-admins.php'</script>";
        }
    }
}