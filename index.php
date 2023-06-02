<?php
require 'config.php';

$pdo = pdo_connect_mysql();



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
    </div>
  </article>
</div>
<?php endforeach ?>
<!-- END PAGE CONTENT -->

<?= template_footer() ?>