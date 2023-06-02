<?php
require 'config.php';

//php to send email (or show the form input) goes here

//create an output message
$responses = [];

//check to see if the form submetted 
if (isset($_POST['name'], $_POST['email'], $_POST['subject'], $_POST['message'])) {
    //validate the email address
    if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $responses[] = "Email is not valid";
    }
    // make sure the form fields not empty
    if (empty($_POST['name']) || empty($_POST['email']) || empty($_POST['subject']) || empty($_POST['message'])) {
        $responses[] = "Please complete all fields";
    }
    // if no errors
    if(!$responses){
        // send email
        $to = 'mohammedalrashid1@mail.weber.edu';
        $from = 'noreply@weber.edu';
        $subject = $_POST['subject'];
        $message = $_POST['message'];
        $headers = 'From: ' . $from . "/r/n" . 'Reply-To: ' . $_POST['email'] . "/r/n" . 'X-Mailer: PHP/' . phpversion();
        if (mail($to,$subject,$message,$headers)){
            // success
            $responses[] = 'Message sent!';
        } else {
            // Fail
            $responses[] = "message could not be sent! Please check your mail server settings!";
            var_dump($_POST);
        }
    }
}
?>

<?= template_header('Project 0') ?>
<?= template_nav('Site Title') ?>

    <!-- START PAGE CONTENT -->

    <!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.3/css/bulma.min.css">
    <script defer src="https://use.fontawesome.com/releases/v5.6.3/js/all.js"></script>
    <script src="js/bulma.js"></script>
    <title>Contact us</title>
</head>

<body>
    <section class="section">
        <div class="container">

            <h1 class="title">
                Contact us
            </h1>
            <!-- message sent confirmation message goes here -->

            <?php if ($responses) :?>
                <p class="notification is-danger is-light"><?php echo implode('<br>', $responses); echo "<br>"; var_dump($_POST);?></p>
                <?php endif; ?>
                
            <!-- contact form using the bulma.io syntax goes here -->
            <form action="" method="post">
            <div class="field">
                <label class="label">Name</label>
                <div class="control has-icons-left">
                    <input class="input" type="text" name="name" placeholder="Joe Smith" require>
                    <span class="icon is-left">
                        <i class="fas fa-user"></i>
                    </span>
                </div>
                </div>

                <div class="field">
                <label class="label">Email</label>
                <div class="control has-icons-left">
                    <input class="input" type="email" name="email" placeholder="ex. youremail@mail.com" require>
                    <span class="icon is-left">
                    <i class="fas fa-at"></i>
                    </span>
                    </span>
                </div>
                </div>

                <div class="field">
                <label class="label">Subject</label>
                <div class="control">
                    <input class="input" type="text" name="subject" placeholder="Enter Subject here" require>
                </div>
            </div>

                <div class="field">
                <label class="label">Message</label>
                <div class="control">
                    <textarea class="textarea" name="message" placeholder="What's on your mind?" require></textarea>
                </div>
                </div>

                <div class="field">
                <div class="control">
                    <button class="button">
                        <span class="icon">
                            <i class="fas fa-paper-plane"></i>

                        </span>
                        <span>Send Message</span>
                </button>
                </div>
                </div>
            </form>

        </div>
    </section>
</body>

</html>
    <!-- END PAGE CONTENT -->

<?= template_footer() ?>