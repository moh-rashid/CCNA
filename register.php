<?php
require 'config.php';

$responses = [];

if (isset($_POST['username'],$_POST['password'],$_POST['email'])) {

    // check username already taken
    if ($stmt = $con->prepare('SELECT id, password FROM accounts WHERE username = ?')) {
    $stmt->bind_param('s', $_POST['username']);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0)   {
        $responses[] = 'Username is already exists. please choose another.';

    } else {
        if ($stmt= $con->prepare('INSERT INTO `accounts` (`username`, `password`, `email`, `activation_code`) VALUES (?,?,?,?)')) {
            $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
            $uniqid = uniqid();
            $stmt->bind_param('ssss', $_POST['username'], $password, $_POST['email'], $uniqid);
            $stmt->execute();

            $activation_link = getMyUrl() . '/activate.php?email=' . $_POST['email'] . '&code=' . $uniqid;
            $responses[] = 'pleaase click the following link to activate your account: a> herf="' . $activation_link . '">' . '</a>';   
        } else {
           $responses[] = 'Could not prepare the INSERT statement.' ;
        }
    }
    $stmt->close();
    } else {
        $responses[] = 'Could not prepare the SELECT statement.';
    }
    $con->close();
}


?>
<?= template_header('Register') ?>
<?= template_nav('Site Title') ?>

    <!-- START PAGE CONTENT -->
    <h1 class="title">Register</h1>
    <?php if ($responses) : ?>
    <p class="notification is-danger is-light"><?php echo implode('<br>', $responses);
                                                echo "<br>";
                                                var_dump($_POST); ?></p>
<?php endif; ?>
    <form action="" method="post">
    <div class="field">
        <label class="label">Username</label>
        <div class="control has-icons-left">
            <input class="input" type="text" name="username" placeholder="jsmith" required>
            <span class="icon is-left">
                <i class="fas fa-user"></i>
            </span>
        </div>
    </div>
    <div class="field">
        <label class="label">Password</label>
        <div class="control has-icons-left">
            <input class="input" type="password" name="password" placeholder="Password" required>
            <span class="icon is-left">
                <i class="fas fa-lock"></i>
            </span>
        </div>
    </div>
    <div class="field">
        <label class="label">Email</label>
        <div class="control has-icons-left">
            <input class="input" type="email" name="email" placeholder="jsmith@gmail.com" required>
            <span class="icon is-left">
                
                <i class="fa-solid fa-at"></i>
            </span>
        </div>
    </div>
    <div class="field">
        <p class="control">
            <button class="button is-success">
                Register
            </button>
        </p>
    </div>
</form>
    <!-- END PAGE CONTENT -->

<?= template_footer() ?>