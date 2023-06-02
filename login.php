<?php
require 'config.php';

//create response message array
$responses = [];

//start a user session
session_start();

// check if data from login was submitted
//isset() will check if data exist

if(isset($_POST['username'], $_POST['password'])) {
    // prepare our sql, preparing the sql statment will prevent sql injection
    if ($stmt = $con->prepare('SELECT id, password, activation_code, email FROM accounts WHERE username = ?')) {
        // bind parameters (s = string, i = int, b = blob, etc),
        //in our case the username is a string so we use "S""
        $stmt->bind_param('s', $_POST['username']);
        $stmt->execute();
        // store the result so we can check if the account exist in the database.
        $stmt->store_result();
        // check if any record were returned from the accounts table taht match the username
        if($stmt->num_rows() > 0) {
            // bind the result into bound var
            $stmt->bind_result($id, $password, $activation_code, $email);
            $stmt->fetch();
        if ($activation_code != "activated") {
            if ($stmt = $con->prepare('UPDATE `accounts` SET `activation_code` = ? WHERE `username` = ?')) {
                // Creating a new Activation Code
                $uniqid = uniqid();
                // Bind the Parameters
                $stmt->bind_param('ss', $uniqid, $_POST['username']);
                $stmt->execute();
                // Create new activation link
                $activation_link = getMyUrl() . '/activate.php?email=' . $email . '&code=' . $uniqid;
                // Provide activation link again.
                $responses[] = "Oh no! It looks like you haven't activated your account yet. Click <a href='" . $activation_link . "'>here</a> to activate your account.";
            } else {
                    $responses[] = "There was an error generating a new activation link.";
            }
            } else {
                // Account exists, now we verify the password.
                // password_verify(string $password, string $hash)
                if (password_verify($_POST['password'], $password)) {
                    // Verify success! User has logged-in!
                    // Create session variables, so we know the user is logged in,
                    // session variables act like cookies but keep the data on the server.
                    session_regenerate_id();
                    $_SESSION['loggedin'] = TRUE;
                    $_SESSION['name'] = $_POST['username'];
                    $_SESSION['id'] = $id;
                    //Create a welcome message
                    $responses[] = "Welcome " .$_SESSION['name'] . "!";
                    // Redirect to the profile page
                     header('Location: profile.php');
            } else {
                // Incorrect password
                $responses[] = 'Incorrect password!';
            }
        }
        } else {
            // Incorrect username
            $responses[] = 'Incorrect username!';
        }
    }
}


?>

<?= template_header('Page Title') ?>
<?= template_nav('Site Title') ?>

    <!-- START PAGE CONTENT -->
    <h1 class="title">Page Heading</h1>
    <?php if ($responses) :?>
        <p class="notification is-danger is-light"><?php echo implode('<br>', $responses); echo "<br>"; var_dump($_POST);?></p>
    <?php endif; ?>   
    <form action="" method="post">
    <div class="field">
        <label class="label">Username</label>
        <div class="control has-icons-left">
            <input class="input" type="text" name="username" placeholder="jsmith" require>
            <span class="icon is-left">
                <i class="fas fa-user"></i>
            </span>
        </div>
        </div>

        <div class="field">
        <label class="label">Password</label>
        <div class="control has-icons-left">
            <input class="input" type="password" name="password" placeholder="Password" require>
            <span class="icon is-left">
                <i class="fas fa-lock"></i>
            </span>
        </div>
        </div>
        <div class="field">
         <p class="control">
            <button class="button is-success">
            Login
            </button>
        </p>
        </div>
    </form>
    
    <!-- END PAGE CONTENT -->

<?= template_footer() ?>