<?php
require 'config.php';

$responses = [];


$pdo = pdo_connect_mysql();

// check if post data is not empty
if (!empty($_POST)){

    //check if the data from the form elements is set
    $author_name = isset($_POST['author_name']) ? $_POST['author_name'] : '';
    $title = isset($_POST['title']) ? $_POST['title'] : '';
    $content = isset($_POST['content']) ? $_POST['content'] : '';

    // insert the poll record into the polls table
    $stmt = $pdo->prepare('INSERT INTO `blog_post`(`author_name`, `title`, `content`) VALUES (?,?,?)');
    $stmt->execute([$author_name, $title, $content]);

    //get the new poll id
    $blog_id = $pdo->lastInsertId();

    //create the message your poll was created successfully
    $responses[] = "Your blog was created successfully! <a href='index.php'>Return to blog page</a>";
}

?>

<?= template_header('Page Title') ?>
<?= template_nav('Site Title') ?>

<!-- START PAGE CONTENT -->
<h1 class="title">Create Blog</h1>
<?php if ($responses) : ?>
<p class="notification is-danger is-light">
    <?php echo implode('<br>', $responses); ?>
</p>
<?php endif; ?>

<form action="" method="post">
    <div class="field">
        <label class="label">Title</label>
        <div class="control has-icons-left">
            <input class="input" type="text" name="title" placeholder="Blog Title" required>
            <span class="icon is-left">
                <i class="fas fa-user"></i>
            </span>
        </div>
    </div>
    <div class="field">
        <label class="label">Auther Name</label>
        <div class="control has-icons-left">
            <input class="input" type="txt" name="author_name" placeholder="Mohammed Rashid" required>
            <span class="icon is-left">
                <i class="fas fa-user"></i>
            </span>
        </div>
    </div>
    <div class="field">
        <label class="label">Content</label>
        <div class="control has-icons-left">
            <input class="input" type="txt" name="content" placeholder="Your content here..." required>
            <span class="icon is-left">
                <i class="fas fa-phone"></i>
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


<!-- END PAGE CONTENT --><!-- END PAGE CONTENT -->

<?= template_footer() ?>