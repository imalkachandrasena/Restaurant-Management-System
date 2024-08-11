<?php
    session_start();
    session_unset();
    session_destroy();

    header("location: http://localhost/resttaste/admin-panel/admins/login-admins.php");