<?php require "../config/config.php"; ?>
<?php require "../libs/App.php"; ?>
<?php require "../includes/header.php"; ?>
<?php 

    $query = "SELECT * FROM bookings WHERE user_id='$_SESSION[user_id]'";
    //$query2 = "SELECT * FROM reviews WHERE user_id='$_SESSION[user_id]'";
    $app = new App;

    //$reviews = $app->selectAll($query2);
    $bookings = $app->selectAll($query);


?>

            <div class="container-xxl py-5 bg-dark hero-header mb-5">
                <div class="container text-center my-5 pt-5 pb-4">
                    <h1 class="display-3 text-white mb-3 animated slideInDown">Bookings</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb justify-content-center text-uppercase">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item"><a href="<?php echo APPURL; ?>/users/bookings.php?id=<?php echo $_SESSION['user_id']; ?>">Bookings</a></li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <!-- Navbar & Hero End -->

        <!-- Service Start -->
            <div class="container">
                <div class="col-md-12">
                    <table class="table">
                        <thead>
                          <tr>
                            <th scope="col">Name</th>
                            <th scope="col">Email</th>
                            <th scope="col">Date Booking</th>
                            <th scope="col">People</th>
                            <th scope="col">Special Request</th>
                            <th scope="col">Status</th>
                            <th scope="col">Review</th>
                          </tr>
                        </thead>
                        <tbody>
                            <?php if(sizeof($bookings) > 0) : ?>
                                <?php foreach($bookings as $booking) : ?>
                                    <tr>
                                        <th><?php echo $booking->name; ?></th>
                                        <td><?php echo $booking->email; ?></td>
                                        <td><?php echo $booking->date_booking; ?></td>
                                        <td><?php echo $booking->num_people; ?></td>
                                        <td><?php echo $booking->special_request; ?></td>
                                        <td><?php echo $booking->status; ?></td>
                                        <?php if($booking->status == "Confirmed") : ?>

                                                <td><a href="<?php echo APPURL; ?>/users/review.php" class="btn btn-success text-white">review us</td>

                                        <?php endif; ?>    
                                    </tr>
                                <?php endforeach; ?>
                            <?php else : ?>
                                <div class="alert alert-info text-danger bg-transparent">You have not booked any reservation.</div>
                            <?php endif; ?>
                        </tbody>
                      </table>
                      
                </div>
            </div>
        <!-- Service End -->
        

<?php require "../includes/footer.php"; ?>
