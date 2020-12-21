<?php
session_start();
include("config/config.php");
if ($_SESSION[SESSION_NAME]) {
    header("location: ". ADMIN);
} else {
    header("location: ". SIGNIN);
}
