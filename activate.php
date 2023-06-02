<?php
require 'config.php';

if (isset($_GET['email'], $_GET['code'])) {
    if ($stmt = $con->prepare('SELECT * FROM accounts WHERE email = ? AND activation_code = ?')) {
            $stmt->bind_param('ss', $_GET['email'], $_GET['code']);
            $stmt->execute();
            $stmt->store_result();
            if ($stmt->num_rows > 0) {
               if ($stmt = $con->prepare('UPDATE `accounts` SET `activation_code`= ? WHERE `email` = ? AND `activation_code` = ?')) {
                $newcode = 'activated';
                $stmt->bind_param('sss', $newcode, $_GET['email'], $_GET['code']);
                $stmt->execute();
               echo 'your account has been activated! log in at <a herf="login.php"> login </a>';
               }
            }

         }   
    } else { 
    echo 'the account has been already activated.';
}

?>