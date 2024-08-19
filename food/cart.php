<?php require "../config/config.php"; ?>
<?php require "../libs/App.php"; ?>
<?php require "../includes/header.php"; ?>
<?php
    if(!isset($_SESSION['user_id'])) {
        echo "<script>window.location.href='".APPURL."'</script>";
        exit();
    }

    $query = "SELECT * FROM cart WHERE user_id='$_SESSION[user_id]'";
    $app = new App;
    
    $cart_itmes = $app->selectAll($query);

    $cart_price = $app->selectOne("SELECT SUM(price*quantity) AS all_price FROM cart WHERE user_id='$_SESSION[user_id]'");

    if(isset($_POST['submit'])) {
        $_SESSION['total_price'] = $cart_price->all_price;
        echo "<script>window.location.href='checkout.php'</script>";
        exit();
    }

?>
            <div class="container-xxl py-5 bg-dark hero-header mb-5">
                <div class="container text-center my-5 pt-5 pb-4">
                    <h1 class="display-3 text-white mb-3 animated slideInDown">Cart</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb justify-content-center text-uppercase">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item"><a href="#">Cart</a></li>
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
                                <th scope="col">Image</th>
                                <th scope="col">Name</th>
                                <th scope="col">Price</th>
                                <th scope="col">Quantity</th>
                                <th scope="col">Total</th>
                                <th scope="col">Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if($cart_price->all_price > 0) : ?>
                                <?php foreach($cart_itmes as $cart_item) : ?>
                                    <tr>
                                        <th><img src="<?php echo APPIMAGES; ?>/<?php echo $cart_item->image; ?>" style="width: 50px; height: 50px"></th>
                                        <td><?php echo $cart_item->name; ?></td>
                                        <td>Rs:<?php echo $cart_item->price ?></td>
                                        <td>
                                            <form class="update-quantity-form" data-item-id="<?php echo $cart_item->id; ?>" >
                                                <input type="number" name="quantity" value="<?php echo $cart_item->quantity; ?>" min="1" style="width: 60px;">
                                                <button type="submit" class="btn btn-secondary btn-sm">Update</button>
                                            </form>
                                        </td>
                                        <td>Rs:<?php echo $cart_item->price * $cart_item->quantity; ?></td>
                                        <td><a href="<?php echo APPURL; ?>/food/delete-item.php?id=<?php echo $cart_item->id; ?>" class="btn btn-danger text-white">delete</td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else : ?>
                                <div class="alert alert-info text-danger bg-transparent">cart is empty add some food items</div>
                            <?php endif; ?>
                        </tbody>
                      </table>
                      <div class="position-relative mx-auto" style="max-width: 400px; padding-left: 679px;">
                        <p style="margin-left: -7px;" class="w-19 py-3 ps-4 pe-5" type="text"> Total:Rs.<?php echo $cart_price->all_price; ?></p>
                        <?php if($cart_price->all_price > 0) :?>
                            <form method="POST" action="cart.php">
                                <button  name="submit" type="submit" class="btn btn-primary py-2 top-0 end-0 mt-2 me-2">Checkout</button>
                            </form>
                        <?php else : ?>
                            <p></p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <!-- Service End -->

    <script>
        document.querySelectorAll('.update-quantity-form').forEach(form =>{
            form.addEventListener('submit',function(event){
                event.preventDefault();

                //gather form data
                const itemId = this.getAttribute('data-item-id');
                const quantity = this.querySelector('input[name="quantity"]').value;

                fetch('update_quantity.php',{
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    }
                    body: `item_id = ${'item_Id'}`&quantity
                })
                    .then(response => response.text())
                    .then(data => {
                        console.log(data);
                    })
                    .catch(error => console.error('Error:', error));
            });
        });
    </script>

<?php require "../includes/footer.php"; ?>