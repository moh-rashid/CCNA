<?php
require 'config.php';

$responses = [];

// use PDO to connect to our db
$pdo = pdo_connect_mysql();

if (isset($_GET['id'])) {
    //get the contact from the DB
    $stmt = $pdo->prepare('SELECT * FROM contacts WHERE id = ?');
    $stmt->execute([$_GET['id']]);
    $contact = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$contact) {
        exit('A contact did not exist with that ID.');
    }

    //update the record after the form is submited
    if (!empty($_POST)) {
        //PHP ternary operator
        // $result = condition ? 'true result : 'false result';
        $name = isset($_POST['name']) ? $_POST['name'] : '';
        $email = isset($_POST['email']) ? $_POST['email'] : '';
        $phone = isset($_POST['phone']) ? $_POST['phone'] : '';
        $title = isset($_POST['title']) ? $_POST['title'] : '';

        $stmt = $pdo->prepare('UPDATE `contacts` SET `name` = ?,`email` = ?,`phone` = ?,`title` = ? WHERE `id` = ?');
        $stmt->execute([$name, $email, $phone, $title, $_GET['id']]);
        //$responses[] = 'The record was updated.';
        header('Location: contacts.php');
    }
} else {
    $responses[] = 'No ID was found...';
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

<form action="contact-update.php?id=<?= $contact['id'] ?>" method="post">
    <div class="field">
        <label class="label">Name</label>
        <div class="control has-icons-left">
            <input class="input" type="text" name="name" value="<?= $contact['name'] ?>" required>
            <span class="icon is-left">
                <i class="fas fa-user"></i>
            </span>
        </div>
    </div>
    <div class="field">
        <label class="label">Email</label>
        <div class="control has-icons-left">
            <input class="input" type="email" name="email" value="<?= $contact['email'] ?>" required>
            <span class="icon is-left">
                <i class="fas fa-at"></i>
            </span>
        </div>
    </div>
    <div class="field">
        <label class="label">Phone</label>
        <div class="control has-icons-left">
            <input class="input" type="tel" name="phone" value="<?= $contact['phone'] ?>" required>
            <span class="icon is-left">
                <i class="fas fa-phone"></i>
            </span>
        </div>
    </div>
    <div class="field">
        <label class="label">Title</label>
        <div class="control has-icons-left">
            <input class="input" type="text" name="title" value="<?= $contact['title'] ?>" required>
            <span class="icon is-left">
                <i class="fas fa-user-ninja"></i>
            </span>
        </div>
    </div>
    <div class="field">
        <p class="control">
            <button class="button is-success">
                Update
            </button>
        </p>
    </div>
</form>

<!-- END PAGE CONTENT -->

<?= template_footer() ?>