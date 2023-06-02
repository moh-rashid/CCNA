<?php
require 'config.php';

$responses = [];


// use PDO to connect to our db
$pdo = pdo_connect_mysql();

//Create Record
if (!empty($_POST)) {
    //PHP ternary operator
    // $result = condition ? 'true result : 'false result';
    $name = isset($_POST['name']) ? $_POST['name'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $phone = isset($_POST['phone']) ? $_POST['phone'] : '';
    $title = isset($_POST['title']) ? $_POST['title'] : '';

    $stmt = $pdo->prepare('INSERT INTO `contacts`(`name`, `email`, `phone`, `title`) VALUES (?,?,?,?)');
    $stmt->execute([$name, $email, $phone, $title]);
    $responses[] = "Contact was created.' <a href='contacts.php'>Return to contacts page</a>";
}



?>

<?= template_header('Contact Update') ?>
<?= template_nav('Site Title') ?>

<!-- START PAGE CONTENT -->
<h1 class="title">Contact Update</h1>
<?php if ($responses) : ?>
<p class="notification is-danger is-light">
    <?php echo implode('<br>', $responses); ?>
</p>
<?php endif; ?>

<form action="" method="post">
    <div class="field">
        <label class="label">Name</label>
        <div class="control has-icons-left">
            <input class="input" type="text" name="name" placeholder="Jhon smith" required>
            <span class="icon is-left">
                <i class="fas fa-user"></i>
            </span>
        </div>
    </div>
    <div class="field">
        <label class="label">Email</label>
        <div class="control has-icons-left">
            <input class="input" type="email" name="email" placeholder="email@example.com" required>
            <span class="icon is-left">
                <i class="fas fa-at"></i>
            </span>
        </div>
    </div>
    <div class="field">
        <label class="label">Phone</label>
        <div class="control has-icons-left">
            <input class="input" type="tel" name="phone" placeholder="333-456-2111" required>
            <span class="icon is-left">
                <i class="fas fa-phone"></i>
            </span>
        </div>
    </div>
    <div class="field">
        <label class="label">Title</label>
        <div class="control has-icons-left">
            <input class="input" type="text" name="title" placeholder="Manager" required>
            <span class="icon is-left">
                <i class="fas fa-user-ninja"></i>
            </span>
        </div>
    </div>
    <div class="field">
        <p class="control">
            <button class="button is-success">
                Create
            </button>
        </p>
    </div>
</form>


<!-- END PAGE CONTENT -->

<?= template_footer() ?>