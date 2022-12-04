<?php
session_start();
session_destroy();
echo "<script> window.location.replace('../views/auth/login.php');</script>";