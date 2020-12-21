<?php
session_start();
include("../config/config.php");
include("../server/message.php");
include("../server/db.php");

if (!isset($_SESSION[SESSION_NAME])) {
  header("location: ../" . SIGNIN);
  die();
}

$username = json_decode($_SESSION[SESSION_NAME]);

if (isset($_POST[RQ_SIGNOUT])) {
  unset($_SESSION[SESSION_NAME]);
  header("location: ../" . SIGNIN);
  die();
}


if (isset($_POST["qs-1"]) || isset($_POST["qs-2"]) || isset($_POST["qs-3"]) || isset($_POST["qs-4"])) {
  $link = startConnectToEB();
}

function filterHandling($sql, $cond, $col, $type)
{
  $queryCount = 0;
  for ($i = 0; $i < count($cond); $i++) {
    if (isset($_POST[$cond[$i]]) && strlen($_POST[$cond[$i]]) > 0) {
      if ($queryCount == 0) {
        $sql .= " WHERE ";
      } else {
        $sql .= " AND ";
      }
      $sql .= $col[$i] . " = ";
      if ($type[$i] == "str") {
        $sql .= " \"" . $_POST[$cond[$i]] . "\"";
      } else {
        $sql .= $_POST[$cond[$i]];
      }
      $queryCount++;
    }
  }
  $sql .= ";";
  return $sql;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/1.4.6/tailwind.min.css" />
  <link rel="stylesheet" href="../css/style.css" />
  <title>Bank Managegment</title>
</head>

<body class="font-font-sans">
  <div class="bg-gray-100 bg-opacity-75">
    <!--Topbar-->
    <div class="bg-gray-800 bg-opacity-100 p-4 flex items-center justify-between">
      <div class="flex items-center justify-center space-x-4">
        <div class="logo">EXAMPLE BANK</div>
      </div>
      <div class="ml-auto flex items-center">
        <a class="mr-4 text-gray-200 relative cursor-pointer"><svg class="w-5" viewBox="0 0 512 512">
            <defs></defs>
            <path d="M256 480a80.09 80.09 0 0073.3-48H182.7a80.09 80.09 0 0073.3 48zm144-192v-60.53C400 157 372.64 95.61 304 80l-8-48h-80l-8 48c-68.88 15.61-96 76.76-96 147.47V288l-48 64v48h384v-48z" fill="currentColor"></path>
          </svg>
          <div class="w-2 h-2 rounded-full bg-red-600 absolute top-0 right-0 -mt-2"></div>
        </a>
        <a class="text-gray-200 relative lg:hidden cursor-pointer"><svg class="w-5" viewBox="0 0 48 48">
            <defs></defs>
            <path d="M7.536 11.5H40.5v5H7.536zm0 10H40.5v5H7.536zm0 10H40.5v5H7.536z" fill="currentColor"></path>
          </svg></a>
        <div id="profile" class="hidden lg:flex relative cursor-pointer">
          <img class="w-6 h-6" src="https://www.pavilionweb.com/wp-content/uploads/2017/03/man-300x300.png" />
          <a href="#settings" class="text-gray-300 ml-2"><?php echo $username ?></a>
        </div>
      </div>
    </div>
    <!--Main section-->
    <div id="main" class="min-h-screen flex">
      <!--Slidebar-->
      <div id="slidebar" class="w-64 bg-gray-200 bg-opacity-50 hidden lg:block border-r border-gray-300">
        <div class="p-4 divide-y divide-gray-300">
          <div class="py-1">
            <a href="#" class="p-2 flex items-center rounded text-sm text-gray-700 mt-2 transition duration-100 ease-in-out hover:bg-green-300 hover:text-gray-100 cursor-pointer">
              <svg class="w-4 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
              </svg>
              <div>Home</div>
            </a>
          </div>
          <div class="py-1">
            <a href="#searchcustomer" class="p-2 flex items-center rounded text-sm text-gray-700 mt-2 transition duration-100 ease-in-out hover:bg-blue-600 hover:text-gray-100 cursor-pointer"><svg class="w-4 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
              </svg>
              <div>Search customer</div>
            </a>
            <a href="#addcustomer" class="p-2 flex items-center rounded text-sm text-gray-700 mt-2 transition duration-100 ease-in-out hover:bg-blue-600 hover:text-gray-100 cursor-pointer">
              <svg class="w-4 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
              </svg>
              <div>Add account</div>
            </a>
            <a href="#listaccounts" class="p-2 flex items-center rounded text-sm text-gray-700 mt-2 transition duration-100 ease-in-out hover:bg-blue-600 hover:text-gray-100 cursor-pointer">
              <svg class="w-4 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
              </svg>
              <div>List accounts</div>
            </a>
            <a href="#servicereport" class="p-2 flex items-center rounded text-sm text-gray-700 mt-2 transition duration-100 ease-in-out hover:bg-blue-600 hover:text-gray-100 cursor-pointer"><svg class="w-4 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
              </svg>
              <div>Service report</div>
            </a>
          </div>
          <div>
            <a href="#settings" class="p-2 flex items-center rounded text-sm text-gray-700 mt-2 transition duration-100 ease-in-out hover:bg-red-300 hover:text-gray-100 cursor-pointer">
              <svg class="w-4 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
              </svg>
              <div>Settings</div>
            </a>
          </div>
        </div>
      </div>
      <!--Page content-->
      <div class="flex flex-col flex-1">
        <!--1. Home-->
        <div id="home" class="page">
          <div class="p-4 border-b border-gray-300 bg-white">
            <div class="text-2xl font-normal tracking-wide">Home</div>
          </div>
          <div class="p-4 container">
            <div class="bg-white shadow-md rounded-lg border border-gray-400 mt-6">
              <div class="text-xl text-gray-700 p-4 border-b border-gray-300">
                EXAMPLE BANK
              </div>
            </div>
          </div>
        </div>
        <!--2. Search customer-->
        <div id="searchcustomer" class="page">
          <div class="p-4 border-b border-gray-300 bg-white">
            <div class="text-2xl font-normal tracking-wide">
              Search customer
            </div>
          </div>
          <div class="p-4 container">
            <div class="bg-white shadow-md rounded-lg border border-gray-400 mt-6">
              <div class="text-xl text-gray-700 p-4 border-b border-gray-300">
                1. Enter customer info
              </div>
              <form method="post">
                <div class="divide-y divide-gray-400">

                  <div class="py-4 px-6">
                    <div class="text-sm w-2/6 text-gray-700">First name</div>
                    <div>
                      <input name="fname" class="w-full md:w-1/2 lg:w-2/3 bg-white px-4 placeholder-gray-500 placeholder-opacity-75 outline-none rounded-lg text-base border border-gray-400 h-10 shadow-sm focus:shadow-outline" type="text" placeholder="First name" />
                    </div>
                  </div>

                  <div class="py-4 px-6">
                    <div class="text-sm w-2/6 text-gray-700">Last name</div>
                    <div>
                      <input name="lname" class="w-full md:w-1/2 lg:w-2/3 bg-white px-4 placeholder-gray-500 placeholder-opacity-75 outline-none rounded-lg text-base border border-gray-400 h-10 shadow-sm focus:shadow-outline" type="text" placeholder="Last name" />
                    </div>
                  </div>

                  <div class="py-4 px-6">
                    <div class="text-sm w-2/6 text-gray-700">
                      Customer SSN
                    </div>
                    <div>
                      <input name="cssn" class="w-full md:w-1/2 lg:w-2/3 bg-white px-4 placeholder-gray-500 placeholder-opacity-75 outline-none rounded-lg text-base border border-gray-400 h-10 shadow-sm focus:shadow-outline" type="text" placeholder="Customer SSN" />
                    </div>
                  </div>

                  <div class="p-6 py-4 bg-gray-100 bg-opacity-75 flex items-center justify-between rounded-bl-lg rounded-br-lg">
                    <button name="qs-1" type=submit" class="outline-none p-3 py-2 bg-green-500 rounded-lg text-gray-100 shadow">
                      <div class="text-center uppercase">
                        Search
                      </div>
                    </button>
                  </div>
                </div>
              </form>
            </div>
            <!--Query result-->
            <div id="qr-1">
              <div class="bg-white shadow-md rounded-lg border border-gray-400 mt-6">
                <div class="text-xl text-gray-700 p-4 border-b border-gray-300">
                  2. Query result
                </div>
                <div class="p-6 py-4">
                  <?php
                  // Question 1 request handling
                  function q1rh($link)
                  {
                    if (isset($_POST["qs-1"])) {
                      // Multi constraint handling
                      $sql = filterHandling("SELECT cssn, fName, lName, phoneNum FROM customer", array("fname", "lname", "cssn"), array("fName", "lName", "cssn"), array("str", "str", "str"));
                      if ($result = mysqli_query($link, $sql)) {
                        if (mysqli_num_rows($result) > 0) {
                          echo raiseSuccess("Customers found. Number of results: " . mysqli_num_rows($result));
                          echo "<div class=\"text-sm w-2/6 text-gray-700\">Select for another action</div>";
                          echo "<table class=\"table-auto my-4 text-gray-700 text-center border-collapse border border-gray-300 w-full rounded-lg\">";
                          echo "<thead>";
                          echo "<tr>";
                          echo "<th class=\"border border-green-300 p-1\">Order</th>";
                          echo "<th class=\"border border-green-300 p-1\">SSN</th>";
                          echo "<th class=\"border border-green-300 p-1\">First name</th>";
                          echo "<th class=\"border border-green-300 p-1\">Last name</th>";
                          echo "<th class=\"border border-green-300 p-1\">Phone</th>";
                          echo "<th class=\"border border-green-300 p-1\">Having account</th>";
                          echo "</tr>";
                          echo "</thead>";
                          echo "<tbody>";
                          $i = 1;
                          while ($row = mysqli_fetch_array($result)) {
                            echo "<tr class=\"hover:bg-green-600 hover:text-white cursor-pointer\">";
                            echo "<td class=\"border border-green-300 p-1\">" . $i . "</td>";
                            echo "<td class=\"border border-green-300 p-1\">" . $row['cssn'] . "</td>";
                            echo "<td class=\"border border-green-300 p-1\">" . $row['fName'] . "</td>";
                            echo "<td class=\"border border-green-300 p-1\">" . $row['lName'] . "</td>";
                            echo "<td class=\"border border-green-300 p-1\">" . $row['phoneNum'] . "</td>";
                            // Account ID
                            if ($accidlist = mysqli_query($link, "SELECT accountID FROM customeraccount WHERE cssn = \"" . $row['cssn'] . "\"")) {
                              if (mysqli_num_rows($accidlist) > 0) {
                                echo "<td class=\"border border-green-300 p-1\">";
                                $many = false;
                                while ($a = mysqli_fetch_array($accidlist)) {
                                  if ($many) echo ", ";
                                  echo $a['accountID'];
                                  $many = true;
                                }
                                echo "</td>";
                              } else {
                                echo "<td class=\"border border-green-300 p-1\">Not have accounts</td>";
                              }
                            }
                            echo "</tr>";
                            $i++;
                          }
                          echo "</tbody></table>";
                        } else {
                          echo raiseSuccess("No customers found");
                        }
                        mysqli_free_result($result);
                      } else {
                        echo raiseError(mysqli_error($link) . ". Query command: " . $sql);
                      }
                    }
                  }
                  // Execute the function
                  q1rh($link);
                  ?>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!--3. Add account-->
        <div id="addcustomer" class="page">
          <div class="p-4 border-b border-gray-300 bg-white">
            <div class="text-2xl font-normal tracking-wide">Add account</div>
          </div>
          <div class="p-4 container">
            <div class="bg-white shadow-md rounded-lg border border-gray-400 mt-6">
              <div class="text-xl text-gray-700 p-4 border-b border-gray-300">
                1. Enter new account info
              </div>
              <form method="post">
                <div class="divide-y divide-gray-400">
                  <div class="py-4 px-6">
                    <div class="text-sm w-2/6 text-gray-700">
                      Customer SSN
                    </div>
                    <div>
                      <input name="chosencssn" class="w-full md:w-1/2 lg:w-2/3 bg-white px-4 placeholder-gray-500 placeholder-opacity-75 outline-none rounded-lg text-base border border-gray-400 h-10 shadow-sm focus:shadow-outline text-green-500" type="text" placeholder="Customer SSN" />
                    </div>
                  </div>
                  <div class="py-4 px-6">
                    <div class=" text-sm lg:w-2/6 text-gray-600 mb-2 lg:mb-0">
                      Account's type
                    </div>
                    <label class="radioinputcon mb-2 text-gray-600">
                      Saving account
                      <input type="radio" name="accounttype" value="savingaccount" class="text-sm leading-tight ml-2 text-gray-500" checked="checked">
                      <span class="checkmark"></span>
                    </label>
                    <label class="radioinputcon mb-2 text-gray-600">
                      Checking account
                      <input type="radio" name="accounttype" value="checkingaccount" class="text-sm leading-tight ml-2 text-gray-500">
                      <span class="checkmark"></span>
                    </label>
                    <label class="radioinputcon mb-2 text-gray-600">
                      Loan
                      <input type="radio" name="accounttype" value="loan" class="text-sm leading-tight ml-2 text-gray-500">
                      <span class="checkmark"></span>
                    </label>
                  </div>
                  <div>
                    <div class="py-4 px-6">
                      <div class="text-sm w-2/6 text-gray-700">Account ID</div>
                      <div>
                        <input name="accountid" class="w-full md:w-1/2 lg:w-2/3 bg-white px-4 placeholder-gray-500 placeholder-opacity-75 outline-none rounded-lg text-base border border-gray-400 h-10 shadow-sm focus:shadow-outline" type="text" placeholder="Account ID" />
                      </div>
                    </div>
                  </div>
                  <div class="py-4 px-6">
                    <div class="text-sm w-2/6 text-gray-700">
                      Balance
                    </div>
                    <div>
                      <input name="balance" class="w-full md:w-1/2 lg:w-2/3 bg-white px-4 placeholder-gray-500 placeholder-opacity-75 outline-none rounded-lg text-base border border-gray-400 h-10 shadow-sm focus:shadow-outline" type="text" placeholder="Balance" />
                    </div>
                  </div>
                  <div class="py-4 px-6" name="interestrate">
                    <div class="text-sm w-2/6 text-gray-700">
                      Interest rate
                    </div>
                    <div>
                      <input name="interestrate" class="w-full md:w-1/2 lg:w-2/3 bg-white px-4 placeholder-gray-500 placeholder-opacity-75 outline-none rounded-lg text-base border border-gray-400 h-10 shadow-sm focus:shadow-outline" type="text" placeholder="Interest Rate" />
                    </div>
                  </div>
                  <div class="py-4 px-6">
                    <div class="text-sm w-2/6 text-gray-700">
                      Open date
                    </div>
                    <div>
                      <input name="opendate" class="w-full md:w-1/2 lg:w-2/3 bg-white px-4 placeholder-gray-500 placeholder-opacity-75 outline-none rounded-lg text-base border border-gray-400 h-10 shadow-sm focus:shadow-outline" type="date" />
                    </div>
                  </div>
                  <div class="p-6 py-4 bg-gray-100 bg-opacity-75 flex items-center justify-between rounded-bl-lg rounded-br-lg">
                    <button name="qs-2" type=submit" class="outline-none p-3 py-2 bg-green-500 rounded-lg text-gray-100 shadow">
                      <div class="text-center uppercase">
                        Add new account
                      </div>
                    </button>
                  </div>
                </div>
              </form>
            </div>
            <!--Query result-->
            <div id="qr-2">
              <div class="bg-white shadow-md rounded-lg border border-gray-400 mt-6">
                <div class="text-xl text-gray-700 p-4 border-b border-gray-300">
                  2. Query result
                </div>
                <div class="p-6 py-4">
                  <?php
                  // Question 2 request handling
                  function q2rh($link)
                  {
                    if (isset($_POST["qs-2"])) {
                      // 1. Validation
                      if (!isset($_POST["chosencssn"]) || strlen($_POST["chosencssn"]) == 0) {
                        echo raiseError("Customer SSN cannot be null!");
                        return;
                      }
                      if (!isset($_POST["accounttype"])) {
                        echo raiseError("Choose a account type!");
                        return;
                      }
                      $accountType = $_POST["accounttype"];
                      if (!($accountType == "checkingaccount" || $accountType == "savingaccount" || $accountType == "loan")) {
                        echo raiseError("Wrong account type!");
                        return;
                      }
                      if (!isset($_POST["accountid"]) || strlen($_POST["accountid"]) == 0) {
                        echo raiseError("Account ID cannot be null!");
                        return;
                      }
                      if (!isset($_POST["balance"]) || strlen($_POST["balance"]) == 0) {
                        echo raiseError("Balance cannot be null!");
                        return;
                      }
                      if (!isset($_POST["opendate"]) || strlen($_POST["opendate"]) == 0) {
                        echo raiseError("Open date cannot be null!");
                        return;
                      }
                      if ($accountType == "checkingaccount" && !isset($_POST["interestrate"])) {
                        echo raiseError("Interest rate cannot be null!");
                        return;
                      }
                      // 2. Check cssn in customeraccount
                      $sql = "SELECT cssn FROM customer WHERE cssn = \"" . $_POST["chosencssn"] . "\";";
                      if ($result = mysqli_query($link, $sql)) {
                        if (mysqli_num_rows($result) == 0) {
                          echo raiseError("Wrong CSSN!");
                          return;
                        } else {
                          // Sucess -> check duplicate account id
                          mysqli_free_result($result);
                          $sql = "SELECT accountID FROM customeraccount WHERE cssn = \"" . $_POST["chosencssn"] . "\";";
                          if ($result = mysqli_query($link, $sql)) {
                            if (mysqli_num_rows($result) > 0) {
                              while ($row = mysqli_fetch_array($result)) {
                                if ($row["accountID"] == $_POST["accountid"]) {
                                  echo raiseError("Existed account ID found! Query command: " . $sql);
                                  return;
                                }
                              }
                            }
                            mysqli_free_result($result);
                          } else {
                            echo raiseError(mysqli_error($link) . ". Query command: " . $sql);
                            return;
                          }
                        }
                      } else {
                        echo raiseError(mysqli_error($link) . ". Query command: " . $sql);
                        return;
                      }
                      // 3. Add account
                      $accountType = $_POST["accounttype"];
                      $date = date('Y-m-d', strtotime($_POST["opendate"]));
                      // a. Add to the relationship table first (between customer account)
                      $sql = "INSERT INTO customeraccount (accountID, cssn) VALUES(\"" . $_POST["accountid"] . "\", \"" . $_POST["chosencssn"] . "\");";
                      if ($result = mysqli_query($link, $sql)) {

                        // b. Then add into account
                        $sql = "INSERT INTO " . $accountType . " ";
                        if ($accountType == "savingaccount" || $accountType == "loan") {
                          $sql .= "(accountID, interestRate, balance, openDate) ";
                          $sql .= "VALUES (\"" . $_POST["accountid"] . "\", " . $_POST["interestrate"] . ", " . $_POST["balance"] . ", \"" . $date . "\");";
                        } else if ($accountType == "checkingaccount") {
                          $sql .= "(accountID, balance, openDate) ";
                          $sql .= "VALUES (\"" . $_POST["accountid"] . "\", " . $_POST["balance"] . ", \" " . $date . "\");";
                        }
                        if ($result = mysqli_query($link, $sql)) {
                          echo raiseSuccess("Add account sucessfully!");
                        } else {
                          echo raiseError(mysqli_error($link) . ". Query command: " . $sql);
                        }
                      } else {
                        echo raiseError(mysqli_error($link) . ". Query command: " . $sql);
                      }
                    }
                  }
                  // Execute the function                
                  q2rh($link); ?>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!--4. List accounts-->
        <div id="listaccounts" class="page">
          <div class="p-4 border-b border-gray-300 bg-white">
            <div class="text-2xl font-normal tracking-wide">List accounts</div>
          </div>
          <div class="p-4 container">
            <div class="bg-white shadow-md rounded-lg border border-gray-400 mt-6">
              <div class="text-xl text-gray-700 p-4 border-b border-gray-300">
                1. Enter customer's SSN belonged to the account
              </div>
              <form method="post">
                <div class="divide-y divide-gray-400">
                  <div class="py-4 px-6">
                    <div class="text-sm w-2/6 text-gray-700">
                      Customer SSN
                    </div>
                    <div>
                      <input name="chosencssn" class="w-full md:w-1/2 lg:w-2/3 bg-white px-4 placeholder-gray-500 placeholder-opacity-75 outline-none rounded-lg text-base border border-gray-400 h-10 shadow-sm focus:shadow-outline text-green-500" type="text" placeholder="Customer SSN" />
                    </div>
                  </div>
                  <div class="p-6 py-4 bg-gray-100 bg-opacity-75 flex items-center justify-between rounded-bl-lg rounded-br-lg">
                    <button name="qs-3" type=submit" class="outline-none p-3 py-2 bg-green-500 rounded-lg text-gray-100 shadow">
                      <div class="text-center uppercase">
                        Find all accounts
                      </div>
                    </button>
                  </div>
                </div>
              </form>
            </div>
            <!--Query result-->
            <div id="qr-3">
              <div class="bg-white shadow-md rounded-lg border border-gray-400 mt-6">
                <div class="text-xl text-gray-700 p-4 border-b border-gray-300">
                  2. Query result
                </div>
                <div class="p-6 py-4">
                  <?php
                  // Question 3 request handling
                  function q3rh($link)
                  {
                    if (isset($_POST["qs-3"])) {
                      // 1. Validation
                      if (!isset($_POST["chosencssn"]) || strlen($_POST["chosencssn"]) > 0) {
                      } else {
                        echo raiseError("Customer SSN cannot be null!");
                        return;
                      }
                      // 2. Check cssn in customeraccount
                      $sql = "SELECT cssn FROM customer WHERE cssn = \"" . $_POST["chosencssn"] . "\";";
                      if ($result = mysqli_query($link, $sql)) {
                        if (mysqli_num_rows($result) == 0) {
                          echo raiseError("Wrong CSSN!");
                          return;
                        } else {
                          mysqli_free_result($result);
                          // Get all account id
                          $sql = "SELECT accountID FROM customeraccount WHERE cssn = \"" . $_POST["chosencssn"] . "\";";
                          if ($result = mysqli_query($link, $sql)) {
                            if (mysqli_num_rows($result) > 0) {
                              // Init temp array
                              $savingArr = array();
                              $checkingArr = array();
                              $loanArr = array();
                              // Now store each received account ID.
                              while ($row = mysqli_fetch_array($result)) {
                                $accountID = $row["accountID"];
                                // Saving
                                $sql = "SELECT accountID, balance, openDate, interestRate FROM savingaccount WHERE accountID = \"" . $accountID . "\";";
                                if ($result_acc = mysqli_query($link, $sql)) {
                                  if (mysqli_num_rows($result_acc) > 0) {
                                    while ($row = mysqli_fetch_array($result_acc)) {
                                      array_push($savingArr, $row);
                                    }
                                  }
                                  mysqli_free_result($result_acc);
                                } else {
                                  echo raiseError(mysqli_error($link) . ". Query command: " . $sql);
                                  return;
                                }
                                // Checking
                                $sql = "SELECT accountID, balance, openDate FROM checkingaccount WHERE accountID = \"" . $accountID . "\";";
                                if ($result_acc = mysqli_query($link, $sql)) {
                                  if (mysqli_num_rows($result_acc) > 0) {
                                    while ($row = mysqli_fetch_array($result_acc)) {
                                      array_push($checkingArr, $row);
                                    }
                                  }
                                  mysqli_free_result($result_acc);
                                } else {
                                  echo raiseError(mysqli_error($link) . ". Query command: " . $sql);
                                  return;
                                }
                                // Loan
                                $sql = "SELECT accountID, balance, openDate, interestRate FROM loan WHERE accountID = \"" . $accountID . "\";";
                                if ($result_acc = mysqli_query($link, $sql)) {
                                  if (mysqli_num_rows($result_acc) > 0) {
                                    while ($row = mysqli_fetch_array($result_acc)) {
                                      array_push($loanArr, $row);
                                    }
                                  }
                                  mysqli_free_result($result_acc);
                                } else {
                                  echo raiseError(mysqli_error($link) . ". Query command: " . $sql);
                                  return;
                                }
                              }
                              // Print table to screen
                              // ==> Print 3 table
                              $lenSaving = count($savingArr);
                              echo "<div class=\"text-sm w-2/6 text-gray-700\">";
                              echo "Saving accounts";
                              echo "</div>";
                              if ($lenSaving > 0) {
                                echo raiseSuccess("Saving accounts found");
                                echo "<table class=\"table-auto my-4 text-gray-700 text-center border-collapse border border-gray-300 w-full rounded-lg\">";
                                echo "<thead>";
                                echo "<tr>";
                                echo "<th class=\"border border-green-300 p-1\">Order</th>";
                                echo "<th class=\"border border-green-300 p-1\">Account ID</th>";
                                echo "<th class=\"border border-green-300 p-1\">Interest rate</th>";
                                echo "<th class=\"border border-green-300 p-1\">Balance</th>";
                                echo "<th class=\"border border-green-300 p-1\">Open date</th>";
                                echo "</tr>";
                                echo "</thead>";
                                echo "<tbody>";
                                for ($i = 0; $i < $lenSaving; $i++) {
                                  $row = $savingArr[$i];
                                  echo "<tr class=\"hover:bg-green-600 hover:text-white cursor-pointer\">";
                                  echo "<td class=\"border border-green-300 p-1\">" . ($i + 1) . "</td>";
                                  echo "<td class=\"border border-green-300 p-1\">" . $row['accountID'] . "</td>";
                                  echo "<td class=\"border border-green-300 p-1\">" . $row['interestRate'] . "</td>";
                                  echo "<td class=\"border border-green-300 p-1\">" . $row['balance'] . "</td>";
                                  echo "<td class=\"border border-green-300 p-1\">" . $row['openDate'] . "</td>";
                                  echo "</tr>";
                                }
                                echo "</tbody></table>";
                              } else {
                                echo raiseSuccess("No saving accounts found");
                              }
                              $lenChecking = count($checkingArr);
                              echo "<div class=\"text-sm w-2/6 text-gray-700\">";
                              echo "Checking accounts";
                              echo "</div>";
                              if ($lenChecking > 0) {
                                echo raiseSuccess("Checking accounts found");
                                echo "<table class=\"table-auto my-4 text-gray-700 text-center border-collapse border border-gray-300 w-full rounded-lg\">";
                                echo "<thead>";
                                echo "<tr>";
                                echo "<th class=\"border border-green-300 p-1\">Order</th>";
                                echo "<th class=\"border border-green-300 p-1\">Account ID</th>";
                                echo "<th class=\"border border-green-300 p-1\">Balance</th>";
                                echo "<th class=\"border border-green-300 p-1\">Open date</th>";
                                echo "</tr>";
                                echo "</thead>";
                                echo "<tbody>";
                                for ($i = 0; $i < $lenChecking; $i++) {
                                  $row = $checkingArr[$i];
                                  echo "<tr class=\"hover:bg-green-600 hover:text-white cursor-pointer\">";
                                  echo "<td class=\"border border-green-300 p-1\">" . ($i + 1) . "</td>";
                                  echo "<td class=\"border border-green-300 p-1\">" . $row['accountID'] . "</td>";
                                  echo "<td class=\"border border-green-300 p-1\">" . $row['balance'] . "</td>";
                                  echo "<td class=\"border border-green-300 p-1\">" . $row['openDate'] . "</td>";
                                  echo "</tr>";
                                }
                                echo "</tbody></table>";
                              } else {
                                echo raiseSuccess("No checking accounts found");
                              }
                              $lenLoan = count($loanArr);
                              echo "<div class=\"text-sm w-2/6 text-gray-700\">";
                              echo "Loan accounts";
                              echo "</div>";
                              if ($lenLoan > 0) {
                                echo raiseSuccess("Loan accounts found");
                                echo "<table class=\"table-auto my-4 text-gray-700 text-center border-collapse border border-gray-300 w-full rounded-lg\">";
                                echo "<thead>";
                                echo "<tr>";
                                echo "<th class=\"border border-green-300 p-1\">Order</th>";
                                echo "<th class=\"border border-green-300 p-1\">Account ID</th>";
                                echo "<th class=\"border border-green-300 p-1\">Interest rate</th>";
                                echo "<th class=\"border border-green-300 p-1\">Balance</th>";
                                echo "<th class=\"border border-green-300 p-1\">Open date</th>";
                                echo "</tr>";
                                echo "</thead>";
                                echo "<tbody>";
                                for ($i = 0; $i < $lenLoan; $i++) {
                                  $row = $loanArr[$i];
                                  echo "<tr class=\"hover:bg-green-600 hover:text-white cursor-pointer\">";
                                  echo "<td class=\"border border-green-300 p-1\">" . ($i + 1) . "</td>";
                                  echo "<td class=\"border border-green-300 p-1\">" . $row['accountID'] . "</td>";
                                  echo "<td class=\"border border-green-300 p-1\">" . $row['interestRate'] . "</td>";
                                  echo "<td class=\"border border-green-300 p-1\">" . $row['balance'] . "</td>";
                                  echo "<td class=\"border border-green-300 p-1\">" . $row['openDate'] . "</td>";
                                  echo "</tr>";
                                }
                                echo "</tbody></table>";
                              } else {
                                echo raiseSuccess("No loan accounts found");
                              }


                              mysqli_free_result($result);
                            } else {
                              echo raiseWarning("No account ID found");
                              return;
                            }
                          } else {
                            echo raiseError(mysqli_error($link) . ". Query command: " . $sql);
                            return;
                          }
                        }
                      } else {
                        echo raiseError(mysqli_error($link) . ". Query command: " . $sql);
                        return;
                      }
                    }
                  }
                  // Execute the function                
                  q3rh($link);
                  ?>

                </div>
              </div>
            </div>
          </div>
        </div>
        <!--5. Service report-->
        <div id="servicereport" class="page">
          <div class="p-4 border-b border-gray-300 bg-white">
            <div class="text-2xl font-normal tracking-wide">Service report</div>
          </div>
          <div class="p-4 container">
            <div class="bg-white shadow-md rounded-lg border border-gray-400 mt-6">
              <div class="text-xl text-gray-700 p-4 border-b border-gray-300">
                1. Full of service who served a customer
              </div>
              <form method="post">
                <div class="divide-y divide-gray-400">
                  <div class="py-4 px-6">
                    <div class="text-sm w-2/6 text-gray-700">
                      Filter (for customer only)
                    </div>
                    <div class="py-2">
                      <div name="filterop" class="block">
                        <label value="fa" name='filtertime' class="mb-2 text-gray-600 rounded-lg mr-1 p-2 border-2 border-opacity-75 border-gray-300 bg-gray-100 cursor-pointer text-gray-800 hover:bg-gray-400 hover:border-opacity-100 hover:border-gray-600 hover:text-gray-900">CSSN asc</label>
                        <label value="fd" name='filtertime' class="mb-2 text-gray-600 rounded-lg mr-1 p-2 border-2 border-opacity-75 border-gray-300 bg-gray-100 cursor-pointer text-gray-800 hover:bg-gray-400 hover:border-opacity-100 hover:border-gray-600 hover:text-gray-900">CSSN desc</label>
                        <label value="l05" name='filterquan' class="mb-2 text-gray-600 rounded-lg mr-1 p-2 border-2 border-opacity-75 border-gray-300 bg-gray-100 cursor-pointer text-gray-800 hover:bg-gray-400 hover:border-opacity-100 hover:border-gray-600 hover:text-gray-900">Limit 5</label>
                        <label value="l10" name='filterquan' class="mb-2 text-gray-600 rounded-lg mr-1 p-2 border-2 border-opacity-75 border-gray-300 bg-gray-100 cursor-pointer text-gray-800 hover:bg-gray-400 hover:border-opacity-100 hover:border-gray-600 hover:text-gray-900">Limit 10</label>
                      </div>
                    </div>
                  </div>
                  <div class="p-6 py-4 bg-gray-100 bg-opacity-75 flex items-center justify-between rounded-bl-lg rounded-br-lg">
                    <form name="filter" method="post">
                      <input value="fa" name="filtertime" type="radio" style="visibility: hidden; position: absolute;">
                      <input value="fd" name="filtertime" type="radio" style="visibility: hidden; position: absolute;">
                      <input value="l05" name="filterquan" type="radio" style="visibility: hidden; position: absolute;">
                      <input value="l10" name="filterquan" type="radio" style="visibility: hidden; position: absolute;">
                      <button name="qs-4" type=submit" class="outline-none p-3 py-2 bg-green-500 rounded-lg text-gray-100 shadow">
                        <div class="text-center uppercase">
                          List all services
                        </div>
                      </button>
                    </form>
                  </div>
                </div>
              </form>
            </div>
            <!--Query result-->
            <div id="qr-4">
              <div class="bg-white shadow-md rounded-lg border border-gray-400 mt-6">
                <div class="text-xl text-gray-700 p-4 border-b border-gray-300">
                  2. Query result
                </div>
                <div class="p-6 py-4">
                  <?php
                  // Question 4 request handling
                  function q4rh($link)
                  {
                    if (isset($_POST["qs-4"])) {
                      // 1. Filter
                      $sql_time = "";
                      $sql_quan = "";
                      if (isset($_POST["filtertime"])) {
                        if ($_POST["filtertime"] == "fd") {
                          $sql_time = " ORDER BY cssn DESC";
                        } else if ($_POST["filtertime"] == "fa") {
                          $sql_time = " ORDER BY cssn ASC";
                        }
                      }
                      if (isset($_POST["filterquan"])) {
                        if ($_POST["filterquan"] == "l05") {
                          $sql_quan = " LIMIT 05";
                        } else if ($_POST["filterquan"] == "l10") {
                          $sql_quan = " LIMIT 10";
                        }
                      }
                      // 2. For each cssn 
                      // --> List information of employee
                      // --> List all account
                      // --> Each account, print details
                      $sql = "SELECT * FROM customer" . $sql_time . $sql_quan;
                      if ($result = mysqli_query($link, $sql)) {
                        if (mysqli_num_rows($result) == 0) {
                          echo raiseSuccess("No customers found");
                          return;
                        } else {
                          echo raiseSuccess("Services report generated. Number of results: " . mysqli_num_rows($result));
                          $cusCount = 1;
                          while ($customer = mysqli_fetch_array($result)) {
                            // Biggest block - contain all results
                            echo "<div class=\"block my-4 border border-gray-200 rounded-lg hover:shadow-lg hover:border-2 hover:border-green-500 hover:border-opacity-50\">";
                            echo "<div class=\"block mb-2 bg-gray-200 p-2 rounded-t-lg\">" . $cusCount . ". " . $customer["fName"] . " " . $customer["lName"] . "</div> ";
                            echo "<div class=\"block px-2\">";
                            // --------------
                            echo "<div class=\"block w-3/6 p-1 float-left\">";
                            echo "<div class=\"block mt-4 mb-1\">1. Customer's info</div>";
                            // Table 1
                            echo "<table class=\"table-fixed text-gray-700 text-left text-sm border-collapse border border-gray-300 w-full rounded-lg\">";
                            echo "<tbody>";
                            echo "<tr class=\"hover:bg-green-600 hover:text-white cursor-pointer\">";
                            echo "<td class=\"w-1/4 border border-green-300 p-1\">" . "Customer SSN" . "</td>";
                            echo "<td class=\"border border-green-300 p-1\">" .  $customer["cssn"]  . "</td>";
                            echo "</tr>";
                            echo "<tr class=\"hover:bg-green-600 hover:text-white cursor-pointer\">";
                            echo "<td class=\"border border-green-300 p-1\">" . "Name" . "</td>";
                            echo "<td class=\"border border-green-300 p-1\">" .  $customer["fName"] . " " .  $customer["lName"] . "</td>";
                            echo "</tr>";
                            echo "<tr class=\"hover:bg-green-600 hover:text-white cursor-pointer\">";
                            echo "<td class=\"border border-green-300 p-1\">" . "Home address" . "</td>";
                            echo "<td class=\"border border-green-300 p-1\">" .  $customer["homeAddr"] . "</td>";
                            echo "</tr>";
                            echo "<tr class=\"hover:bg-green-600 hover:text-white cursor-pointer\">";
                            echo "<td class=\"border border-green-300 p-1\">" . "Office address" . "</td>";
                            echo "<td class=\"border border-green-300 p-1\">" .  $customer["officeAddr"] . "</td>";
                            echo "</tr>";
                            echo "<tr class=\"hover:bg-green-600 hover:text-white cursor-pointer\">";
                            echo "<td class=\"border border-green-300 p-1\">" . "Phone number" . "</td>";
                            echo "<td class=\"border border-green-300 p-1\">" .  $customer["phoneNum"] . "</td>";
                            echo "</tr>";
                            echo "<tr class=\"hover:bg-green-600 hover:text-white cursor-pointer\">";
                            echo "<td class=\"border border-green-300 p-1\">" . "Email" . "</td>";
                            echo "<td class=\"border border-green-300 p-1\">" .  $customer["email"] . "</td>";
                            echo "</tr>";
                            echo "</tbody></table>";
                            echo "</div>";

                            $sql = "SELECT * FROM employee WHERE essn = \"" . $customer["essn"] . "\";";
                            if ($result_2 = mysqli_query($link, $sql)) {
                              if (mysqli_num_rows($result) == 0) {
                                raiseSuccess("No employees found");
                              } else {
                                $emp = mysqli_fetch_array($result_2);
                                // 
                                echo "<div class=\"block w-3/6 p-1 float-left\">";
                                echo "<div class=\"block mt-4 mb-1\">2. Employee's info</div>";
                                // Employee
                                echo "<table class=\"table-fixed text-gray-700 text-left text-sm border-collapse border border-gray-300 w-full rounded-lg\">";
                                echo "<tbody>";
                                echo "<tr class=\"hover:bg-green-600 hover:text-white cursor-pointer\">";
                                echo "<td class=\"w-1/4 border border-green-300 p-1\">" . "Employee SSN" . "</td>";
                                echo "<td class=\"border border-green-300 p-1\">" .  $emp["essn"]  . "</td>";
                                echo "</tr>";
                                echo "<tr class=\"hover:bg-green-600 hover:text-white cursor-pointer\">";
                                echo "<td class=\"border border-green-300 p-1\">" . "Name" . "</td>";
                                echo "<td class=\"border border-green-300 p-1\">" .  $emp["fName"] . " " .  $emp["lName"] . "</td>";
                                echo "</tr>";
                                echo "<tr class=\"hover:bg-green-600 hover:text-white cursor-pointer\">";
                                echo "<td class=\"border border-green-300 p-1\">" . "Birth date" . "</td>";
                                echo "<td class=\"border border-green-300 p-1\">" .  $emp["bDate"] . "</td>";
                                echo "</tr>";
                                echo "<tr class=\"hover:bg-green-600 hover:text-white cursor-pointer\">";
                                echo "<td class=\"border border-green-300 p-1\">" . "Home address" . "</td>";
                                echo "<td class=\"border border-green-300 p-1\">" .  $emp["addressNo"] . ", " . $emp["addressStreet"] . ", " . $emp["addressDistrict"] . ", " . $emp["addressCity"] . ", " . $emp["bName"] . "</td>";
                                echo "</tr>";
                                echo "<tr class=\"hover:bg-green-600 hover:text-white cursor-pointer\">";
                                echo "<td class=\"border border-green-300 p-1\">" . "Phone number" . "</td>";
                                echo "<td class=\"border border-green-300 p-1\">" .  $emp["phoneNum"] . "</td>";
                                echo "</tr>";
                                echo "<tr class=\"hover:bg-green-600 hover:text-white cursor-pointer\">";
                                echo "<td class=\"border border-green-300 p-1\">" . "Email" . "</td>";
                                echo "<td class=\"border border-green-300 p-1\">" .  $emp["email"] . "</td>";
                                echo "</tr>";
                                echo "</tbody></table>";
                                echo "</div>";
                              }
                            } else {
                              echo raiseError(mysqli_error($link) . ". Query command: " . $sql);
                              return;
                            }
                            mysqli_free_result($result_2);
                            // Init temp array
                            $savingArr = array();
                            $checkingArr = array();
                            $loanArr = array();
                            $sql = "SELECT * FROM customeraccount WHERE cssn = \"" . $customer["cssn"] . "\";";
                            if ($result_2 = mysqli_query($link, $sql)) {
                              if (mysqli_num_rows($result) == 0) {
                                raiseSuccess("No accounts found");
                              } else {
                                echo "<div class=\"block w-full p-1 float-left\">";
                                echo "<div class=\"block mt-4 mb-1\">3. All customer's accounts: </div>";
                                while ($cusacc = mysqli_fetch_array($result_2)) {
                                  $accountID = $cusacc["accountID"];
                                  // Saving
                                  $sql = "SELECT accountID, balance, openDate, interestRate FROM savingaccount WHERE accountID = \"" . $accountID . "\";";
                                  if ($result_acc = mysqli_query($link, $sql)) {
                                    if (mysqli_num_rows($result_acc) > 0) {
                                      while ($row = mysqli_fetch_array($result_acc)) {
                                        array_push($savingArr, $row);
                                      }
                                    }
                                    mysqli_free_result($result_acc);
                                  } else {
                                    echo raiseError(mysqli_error($link) . ". Query command: " . $sql);
                                    return;
                                  }
                                  // Checking
                                  $sql = "SELECT accountID, balance, openDate FROM checkingaccount WHERE accountID = \"" . $accountID . "\";";
                                  if ($result_acc = mysqli_query($link, $sql)) {
                                    if (mysqli_num_rows($result_acc) > 0) {
                                      while ($row = mysqli_fetch_array($result_acc)) {
                                        array_push($checkingArr, $row);
                                      }
                                    }
                                    mysqli_free_result($result_acc);
                                  } else {
                                    echo raiseError(mysqli_error($link) . ". Query command: " . $sql);
                                    return;
                                  }
                                  // Loan
                                  $sql = "SELECT accountID, balance, openDate, interestRate FROM loan WHERE accountID = \"" . $accountID . "\";";
                                  if ($result_acc = mysqli_query($link, $sql)) {
                                    if (mysqli_num_rows($result_acc) > 0) {
                                      while ($row = mysqli_fetch_array($result_acc)) {
                                        array_push($loanArr, $row);
                                      }
                                    }
                                    mysqli_free_result($result_acc);
                                  } else {
                                    echo raiseError(mysqli_error($link) . ". Query command: " . $sql);
                                    return;
                                  }
                                }
                              }
                            } else {
                              echo raiseError(mysqli_error($link) . ". Query command: " . $sql);
                              return;
                            }
                            // == Down
                            // Print table to screen
                            // ==> Print 3 table
                            $lenSaving = count($savingArr);
                            echo "<div class=\"block w-2/6 p-1 float-left\">";
                            echo "<div class=\"text-sm w-full text-gray-700\">";
                            echo "Saving accounts";
                            echo "</div>";
                            if ($lenSaving > 0) {
                              echo "<table class=\"table-auto text-sm my-4 text-gray-700 text-center border-collapse border border-gray-300 w-full rounded-lg\">";
                              echo "<thead>";
                              echo "<tr>";
                              echo "<th class=\"border border-green-300 p-1\">Account ID</th>";
                              echo "<th class=\"border border-green-300 p-1\">Interest rate</th>";
                              echo "<th class=\"border border-green-300 p-1\">Balance</th>";
                              echo "<th class=\"border border-green-300 p-1\">Open date</th>";
                              echo "</tr>";
                              echo "</thead>";
                              echo "<tbody>";
                              for ($i = 0; $i < $lenSaving; $i++) {
                                $row = $savingArr[$i];
                                echo "<tr class=\"hover:bg-green-600 hover:text-white cursor-pointer\">";
                                echo "<td class=\"border border-green-300 p-1\">" . $row['accountID'] . "</td>";
                                echo "<td class=\"border border-green-300 p-1\">" . $row['interestRate'] . "</td>";
                                echo "<td class=\"border border-green-300 p-1\">" . $row['balance'] . "</td>";
                                echo "<td class=\"border border-green-300 p-1\">" . $row['openDate'] . "</td>";
                                echo "</tr>";
                              }
                              echo "</tbody></table>";
                            } else {
                              echo "<div class=\"my-4 text-gray-700 text-sm\">(Not having)</div>";
                            }
                            echo "</div>";

                            $lenChecking = count($checkingArr);
                            echo "<div class=\"block w-2/6 p-1 float-left\">";
                            echo "<div class=\"text-sm w-full text-gray-700\">";
                            echo "Checking accounts";
                            echo "</div>";
                            if ($lenChecking > 0) {

                              echo "<table class=\"table-auto my-4 text-sm text-gray-700 text-center border-collapse border border-gray-300 w-full rounded-lg\">";
                              echo "<thead>";
                              echo "<tr>";
                              echo "<th class=\"border border-green-300 p-1\">Account ID</th>";
                              echo "<th class=\"border border-green-300 p-1\">Balance</th>";
                              echo "<th class=\"border border-green-300 p-1\">Open date</th>";
                              echo "</tr>";
                              echo "</thead>";
                              echo "<tbody>";
                              for ($i = 0; $i < $lenChecking; $i++) {
                                $row = $checkingArr[$i];
                                echo "<tr class=\"hover:bg-green-600 hover:text-white cursor-pointer\">";
                                echo "<td class=\"border border-green-300 p-1\">" . $row['accountID'] . "</td>";
                                echo "<td class=\"border border-green-300 p-1\">" . $row['balance'] . "</td>";
                                echo "<td class=\"border border-green-300 p-1\">" . $row['openDate'] . "</td>";
                                echo "</tr>";
                              }
                              echo "</tbody></table>";
                            } else {
                              echo "<div class=\"my-4 text-gray-700 text-sm\">(Not having)</div>";
                            }
                            echo "</div>";
                            echo "<div class=\"block w-2/6 p-1 float-left\">";
                            $lenLoan = count($loanArr);
                            echo "<div class=\"text-sm w-full  text-gray-700\">";
                            echo "Loan accounts";
                            echo "</div>";
                            if ($lenLoan > 0) {
                              echo "<table class=\"table-auto my-4 text-sm text-gray-700 text-center border-collapse border border-gray-300 v-full rounded-lg\">";
                              echo "<thead>";
                              echo "<tr>";
                              echo "<th class=\"border border-green-300 p-1\">Account ID</th>";
                              echo "<th class=\"border border-green-300 p-1\">Interest rate</th>";
                              echo "<th class=\"border border-green-300 p-1\">Balance</th>";
                              echo "<th class=\"border border-green-300 p-1\">Open date</th>";
                              echo "</tr>";
                              echo "</thead>";
                              echo "<tbody>";
                              for ($i = 0; $i < $lenLoan; $i++) {
                                $row = $loanArr[$i];
                                echo "<tr class=\"hover:bg-green-600 hover:text-white cursor-pointer\">";
                                echo "<td class=\"border border-green-300 p-1\">" . $row['accountID'] . "</td>";
                                echo "<td class=\"border border-green-300 p-1\">" . $row['interestRate'] . "</td>";
                                echo "<td class=\"border border-green-300 p-1\">" . $row['balance'] . "</td>";
                                echo "<td class=\"border border-green-300 p-1\">" . $row['openDate'] . "</td>";
                                echo "</tr>";
                              }
                              echo "</tbody></table>";
                            } else {
                              echo "<div class=\"my-4 text-gray-700 text-sm\">(Not having)</div>";
                            }
                            echo "</div></div>";
                            // Clear both
                            echo "<div class=\"clear-both\"></div>";
                            echo "</div></div>";
                            $cusCount++;
                          }
                        }
                      } else {
                        echo raiseError(mysqli_error($link) . ". Query command: " . $sql);
                        return;
                      }
                    }
                  }
                  // Execute the function                
                  q4rh($link);
                  ?>

                </div>
              </div>
            </div>
          </div>
        </div>
        <!--6. Settings-->
        <div id="settings" class="page">
          <div class="p-4 border-b border-gray-300 bg-white">
            <div class="text-2xl font-normal tracking-wide">Settings</div>
          </div>
          <div class="p-4 container">
            <div class="bg-white shadow-md rounded-lg border border-gray-400 mt-6">
              <div class="text-xl text-gray-700 p-4 border-b border-gray-300">
                Profile
              </div>
              <div>
                <div class="divide-y divide-gray-400">
                  <div class="py-4 px-6 relative cursor-pointer text-gray-700">
                    
                    <div class="py-2 flex justify-start align-center">
                      <img class="w-20 h-20" src="https://www.pavilionweb.com/wp-content/uploads/2017/03/man-300x300.png" />
                      <p class="py-6 px-6">Username: <?php echo $_SESSION[SESSION_NAME] ?></p>
                      <form method="post" class="mt-4">
                        <button name="signout" type="submit" class="outline-none p-3 py-2 bg-red-500 rounded-lg text-gray-100 shadow">
                          <div class="text-center uppercase">
                            Sign out
                          </div>
                        </button>
                      </form>
                    </div>
                    <div class="py-2">
                      <div class="text-sm w-2/6 text-gray-700">
                        Change password
                      </div>
                      <form method="post"">
                        <input name=" fname" class="w-4/6 bg-white px-4 placeholder-gray-500 placeholder-opacity-75 outline-none rounded-lg text-base border border-gray-400 h-10 shadow-sm focus:shadow-outline" type="password" placeholder="New password name" />
                      <button name="changepassword" type="submit" class="ml-4 outline-none p-3 py-2 bg-yellow-500 rounded-lg text-gray-100 shadow">
                        <div class="text-center uppercase">
                          Change password
                        </div>
                      </button>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="../js/message.js"></script>
  <script src="js/home.js"></script>
</body>

</html>