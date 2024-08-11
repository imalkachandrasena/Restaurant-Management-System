<?php require "../config/config.php"; ?>
<?php require "../libs/App.php"; ?>
<?php require "../includes/header.php"; ?>
<?php
    $app = new App;   
    $app->validateSession();

    if(isset($_POST['submit'])) {
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $confirm_password = $_POST['confirm_password'];

        $errors = [];

        if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
            $errors['email'] = "Invalid email format";
        }

        if(strlen($password) < 8){
            $errors['password'] = "Password must be at least 8 characters longs";
        }

        if($password!==$confirm_password){
            $errors['confirm_password'] = "Passwords do not match";
        }

        if(empty($errors)){
            $query = "INSERT INTO users (username, email, password) VALUES (:username, :email, :password)";

            $arr = [
                ":username" =>  $username,
                ":email" =>  $email,
                ":password" =>  $password,
            ];

            $path = "login.php";

            $app->register($query, $arr, $path);
        }else{
            $_SESSION['registration_errors'] = $errors;
            header("Location: register.php");
            exit;
        }
    }
?>

            <div class="container-xxl py-5 bg-dark hero-header mb-5">
                <div class="container text-center my-5 pt-5 pb-4">
                    <h1 class="display-3 text-white mb-3 animated slideInDown">Registration</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb justify-content-center text-uppercase">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item"><a href="#">Register</a></li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <!-- Navbar & Hero End -->

        <!-- Service Start -->
            <div class="container">
                <div class="col-md-12 bg-dark">
                    <div class="p-5 wow fadeInUp" data-wow-delay="0.2s">
                        <h5 class="section-title ff-secondary text-start text-primary fw-normal">Register</h5>
                        <h1 class="text-white mb-4">Register for a new user</h1>

                        <?php
                        if(isset($_SESSION['registration_errors'])) {
                            $errors = $_SESSION['registration_errors'];
                            foreach($errors as $error) {
                                echo "<div class='alert alert-danger'>$error</div>";
                            }
                            unset($_SESSION['registration_errors']);
                        }
                        ?>

                        <form class="col-md-12" method="POST" action="register.php" onsubmit="return confirmRegister()" >
                            <div class="row g-3">
                                <div class="">
                                    <div class="form-floating">
                                        <input name="username" type="text" class="form-control" id="name" placeholder="Your Name" required>
                                        <label for="name">Username</label>
                                    </div>
                                </div>
                                <div class="">
                                    <div class="form-floating">
                                        <input name="email" type="email" class="form-control" id="email" placeholder="Your Email" required>
                                        <label for="email">Your Email</label>
                                    </div>
                                </div>
                                <div class="">
                                    <div class="form-floating">
                                        <input name="password" type="password" class="form-control" id="password" placeholder="Your Password" required>
                                        <label for="password">Password</label>
                                    </div>
                                </div>
                                <div class="">
                                    <div class="form-floating">
                                        <input name="confirm_password" type="password" class="form-control" id="confirm_password" placeholder="Confirm Password" required>
                                        <label for="password">Confirm Password</label>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <button name="submit" class="btn btn-primary w-100 py-3" type="submit">Register</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        <!-- Service End -->

        <script>
            function confirmRegister(){
                alert("New customer registration successful.");
                return true;
            }
        </script>

<?php require "../includes/footer.php"; ?>  