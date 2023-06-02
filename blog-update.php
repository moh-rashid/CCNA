<?php
require 'config.php';

$responses = [];

// use PDO to connect to our db
$pdo = pdo_connect_mysql();

if (isset($_GET['id'])) {
    //get the blog from the DB
    $stmt = $pdo->prepare('SELECT * FROM blog_post WHERE id = ?');
    $stmt->execute([$_GET['id']]);
    $blog = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$blog) {
        exit('A blog did not exist with that ID.');
    }

    //update the record after the form is submited
    if (!empty($_POST)) {
        //PHP ternary operator
        // $result = condition ? 'true result : 'false result';
        $author_name = isset($_POST['author_name']) ? $_POST['author_name'] : '';
        $title = isset($_POST['title']) ? $_POST['title'] : '';
        $content = isset($_POST['content']) ? $_POST['content'] : '';
    

        $stmt = $pdo->prepare('UPDATE `blog_post` SET `author_name`=?,`title`=?,`content`=? WHERE `id` = ?');
        $stmt->execute([$author_name, $title, $content,  $_GET['id']]);
        $responses[] = 'blog updated..';
        //header('Location: index.php');
    }
} else {
    $responses[] = 'No ID was found...';
}

?>

<?= template_header('blog Update') ?>
<?= template_nav('Site Title') ?>

<!-- START PAGE CONTENT -->
<h1 class="title">blog Update</h1>
<?php if ($responses) : ?>
    <p class="notification is-danger is-light">
        <?php echo implode('<br>', $responses); ?>
    </p>
<?php endif; ?>

<form action="blog-update.php?id=<?= $blog['id'] ?>" method="post">
    <div class="field">
        <label class="label">Title</label>
        <div class="control has-icons-left">
            <input class="input" type="text" name="title" value="<?= $blog['title'] ?>" required>
            <span class="icon is-left">
                <i class="fas fa-user"></i>
            </span>
        </div>
    </div>
    <div class="field">
        <label class="label">Author Name</label>
        <div class="control has-icons-left">
            <input class="input" type="txt" name="author_name" value="<?= $blog['author_name'] ?>" required>
            <span class="icon is-left">
                <i class="fas fa-phone"></i>
            </span>
        </div>
    </div>
    <div class="field">
        <label class="label">Content</label>
        <div class="control has-icons-left">
            <input class="input" type="text" name="content" value="<?= $blog['content'] ?>" required>
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