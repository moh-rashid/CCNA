<?php
require 'config.php';

$responses = [];

// use PDO to connect to our db
$pdo = pdo_connect_mysql();
$stmt = $pdo->prepare('SELECT * FROM contacts WHERE id');
//$stmt->execute([$_GET['id']]);
$stmt->execute();
$contacts = $stmt->fetchAll(PDO::FETCH_ASSOC);


?>
<?= template_header('Contacts') ?>
<?= template_nav('Site Title') ?>

<!-- START PAGE CONTENT -->
<h1 class="title">Contacts</h1>
<a href="contact-create.php" class="button is-success">Create Contact</a>

<table class="table">
    <thead>
        <tr>
            <th><abbr title="id">ID</abbr></th>
            <th><abbr title="name">Name</abbr></th>
            <th><abbr title="email">Email</abbr></th>
            <th><abbr title="phone">Phone Number</abbr></th>
            <th><abbr title="title">Title</abbr></th>
            <th><abbr title="title">Created</abbr></th>
        </tr>
    </thead>

    <tbody>
        <?php foreach($contacts as $contact): ?>
        <tr>
            <td><?= $contact['id'] ?></td>
            <th><?= $contact['name'] ?></th>
            <td><?= $contact['email'] ?></td>
            <td><?= $contact['phone'] ?></td>
            <td><?= $contact['title'] ?></td>
            <td><?= $contact['created'] ?></td>
            <td>
                <a href="contact-update.php?id=<?= $contact['id'] ?>" class="button is-info">
                    <i class="fas fa-pen"></i>
                </a>
                <a href="contact-delete.php?id=<?= $contact['id'] ?>" class="button is-danger">
                    <i class="fas fa-trash"></i>
                </a>
            </td>
        </tr>
        <?php endforeach;?>

    </tbody>
</table>

<!-- END PAGE CONTENT -->

<?= template_footer() ?>