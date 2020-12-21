<?php
session_start();
include("../config/config.php");
include("../server/db.php");
include("../server/message.php");
// Array of messages (for each pages), indicate success or failure operation
$msg = "";

// * Login form validator
function validateSignin(&$message)
{
    // Name
    if (!isset($_POST["username"]) || strlen($_POST["username"]) < 5 || strlen($_POST["username"]) > 50) {
        $message = raiseError("Name must be 5 - 50 characters");
        return false;
    }
    // Name
    if (!isset($_POST["password"]) || strlen($_POST["password"]) < 5 || strlen($_POST["password"]) > 50) {
        $message = raiseError("Password must be 5 - 50 characters");
        return false;
    }
    return true;
}

if (isset($_POST[RQ_SIGNIN])) {
    if (validateSignin($msg)) {
        $link = startConnectToEB(); // Start connect to database
        $sql = "SELECT username FROM manager WHERE username =\"" . $_POST["username"] . "\";";
        if ($result = mysqli_query($link, $sql)) {
            if (mysqli_num_rows($result) > 0) {
                $sql = "SELECT username FROM manager WHERE username =\"" . $_POST["username"] . "\" AND password =\"" . $_POST["password"] . "\";";
                if ($result = mysqli_query($link, $sql)) {
                    if (mysqli_num_rows($result) > 0) {
                        $_SESSION[SESSION_NAME] = mysqli_fetch_array($result)["username"];
                    } else {
                        $msg = raiseError("Wrong password");
                    }
                } else {
                    $msg = raiseError("Could not able to execute $sql. " . mysqli_error($link));
                }
            } else {
                $msg = raiseError("Wrong username");
            }
        } else {
            $msg = raiseError("Could not able to execute $sql. " . mysqli_error($link));
        }
        closeConnectToEB($link); // Close
    }
};


if (isset($_SESSION[SESSION_NAME])) {
    header("location: ../" . ADMIN);
    die();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/1.4.6/tailwind.min.css" />
    <link rel="stylesheet" href="../css/style.css">
    <title>Log in</title>
</head>

<body class="font-font-sans">
    <div class="h-screen flex items-center justify-center bg-purple-200">
        <div class="bg-white py-8 px-10 border-t-4 border-purple-500 rounded-md shadow-lg">
            <!--Sign in-->
            <div id="signin">
                <h2 class="text-3xl text-purple-500 mb-3">Sign in</h2>
                <form method="post" onsubmit="return validateSignin()">
                    <?php echo $msg ?>
                    <div class="mb-2">
                        <label class="text-sm">Username</label>
                        <input name="username" type="text" placeholder="Username" class="w-full p-2 mt-1 bg-gray-200 rounded-md focus:outline-none">
                    </div>
                    <div class="mt-2 mb-3">
                        <label class="text-sm">Password</label>
                        <input name="password" type="password" placeholder="Password" class="w-full p-2 mt-1 bg-gray-200 rounded-md focus:outline-none">
                    </div>
                    <button name="signin" class="border-none bg-purple-800 py-2 text-white roudend-sm w-full mt-2 rounded-md hover:bg-green-300 mb-5" type="submit">
                        Sign in
                    </button>
                    <div>
                        <p class="text-sm text-gray-600">For manager only</p>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="js/signin.js"></script>
    <script src="../js/message.js"></script>
</body>

</html>