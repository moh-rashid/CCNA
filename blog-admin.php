<?php
require 'config.php';

$pdo = pdo_connect_mysql();
session_start();


$responses = [];

 // If the user is not logged in redirect them to the login page
 if (!isset($_SESSION['loggedin'])) {
    header('Location: login.php');
    exit;
 }

$stmt = $con->prepare('SELECT password, email FROM accounts WHERE id = ?');
$stmt->bind_param('i', $_SESSION['id']);
$stmt->execute();
$stmt->bind_result($password, $email);
$stmt->fetch();
$stmt->close();

$stmt = $pdo->prepare('SELECT * FROM blog_post ORDER BY id LIMIT 10');
$stmt->execute();
$blogs = $stmt->fetchAll(PDO::FETCH_ASSOC);
$contacts = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<?= template_header('Page Title') ?>
<?= template_nav('Site Title') ?>

<!-- START PAGE CONTENT -->
<h1 class="title">Blog</h1>
<p class="subtitle">Welcome! Here is our list of blogs.</p>
<a href="blog-create.php" class="button is-success">Create Post</a>
<?php foreach ($blogs as $blog) : ?>
<div class="box">
    <div class="media-content">
      <div class="content">
        <p>
          <strong><?= $blog['title'] ?></strong>
          <br>
          <small><?= $blog['author_name'] ?> -</small> <small><?= $blog['created'] ?></small>
          <br>
          <?php echo readMore($blog['content'],"blog-post.php","id",$blog['id'], 100, 100); ?>
        </p>
      </div>
      <nav class="level is-mobile">
        <div class="level-left">
          <a href="blog-delete.php?id=<?= $blog['id'] ?>" class="level-item" >
            <span class="icon is-small">
              <i class="fas fa-trash" aria-hidden="true"></i>
            </span>
          </a>
          <a href="blog-update.php?id=<?= $blog['id'] ?>" class="level-item" >
            <span class="icon is-small">
              <i class="fas fa-pen" aria-hidden="true"></i>
            </span>
          </a>
        </div>
      </nav>
    </div>
  </article>
</div>
<?php endforeach ?>
<!-- END PAGE CONTENT -->

<?= template_footer() ?>