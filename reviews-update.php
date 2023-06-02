<?php
require 'config.php';

$responses = [];

// use PDO to connect to our db
$pdo = pdo_connect_mysql();

if (isset($_GET['id'])) {
    //get the reviews from the DB
    $stmt = $pdo->prepare('SELECT * FROM reviews WHERE id = ?');
    $stmt->execute([$_GET['id']]);
    $reviews = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$reviews) {
        exit('A reviews did not exist with that ID.');
    }

    //update the record after the form is submited
    if (!empty($_POST)) {
        //PHP ternary operator
        // $result = condition ? 'true result : 'false result';
        $name = isset($_POST['name']) ? $_POST['name'] : '';
        $rating = isset($_POST['rating']) ? $_POST['rating'] : '';
        $content = isset($_POST['content']) ? $_POST['content'] : '';
    

        $stmt = $pdo->prepare('UPDATE `reviews` SET `name`= ?,`content`= ?,`rating`= ? WHERE `id` = ?');
        $stmt->execute([$name, $content, $rating,  $_GET['id']]);
        header('Location: reviews.php');
    }
} else {
    $responses[] = 'No ID was found...';
}

?>

<?= template_header('reviews Update') ?>
<?= template_nav('Site Title') ?>

<!-- START PAGE CONTENT -->
<h1 class="title">Review Update</h1>
<?php if ($responses) : ?>
    <p class="notification is-danger is-light">
        <?php echo implode('<br>', $responses); ?>
    </p>
<?php endif; ?>

<form action="reviews-update.php?id=<?= $reviews['id'] ?>" method="post">
    <div class="field">
        <label class="label">Name</label>
        <div class="control has-icons-left">
            <input class="input" type="text" name="name" value="<?= $reviews['name'] ?>" required>
            <span class="icon is-left">
                <i class="fas fa-user"></i>
            </span>
        </div>
    </div>
    <div class="field">
        <label class="label">Rating</label>
        <div class="control has-icons-left">
            <input class="input" type="txt" name="rating" value="<?= $reviews['rating'] ?>" required>
            <span class="icon is-left">
                <i class="fas fa-phone"></i>
            </span>
        </div>
    </div>
    <div class="field">
        <label class="label">Content</label>
        <div class="control has-icons-left">
            <input class="input" type="text" name="content" value="<?= $reviews['content'] ?>" required>
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