<?php require "../config/config.php"; ?>
<?php require "../libs/App.php"; ?>
<?php require "../includes/header.php"; ?>
<?php
    if(!isset($_SERVER['HTTP_REFERER'])){
        // redirect them to your desired location
        echo "<script>window.location.href='".APPURL."'</script>";
        exit;
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        $_SESSION['message'] = "Your order has been placed!";
        echo "<script>window.location.href='delete-cart.php'</script>";
        // Redirect to the same page (or a different one)
        header("Location: " .APPURL. "");
        exit;
    }
?>
        <div class="container-xxl py-5 bg-dark hero-header mb-5">
                <div class="container text-center my-5 pt-5 pb-4">
                    <h1 class="display-3 text-white mb-3 animated slideInDown">Go for Payment</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb justify-content-center text-uppercase">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item"><a href="#">Pay</a></li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    <div class="container">
        <form method="post" action="pay.php" onsubmit="return confirmPayment();">
            <button class="btn btn-primary w-100 py-3" type="submit">Pay Now</button>
        </form>

    </div>

    <script>
        function confirmPayment(){
            alert("Your Payment has been done.")
            return true;
        }
    </script>
<?php require "../includes/footer.php"; ?>
