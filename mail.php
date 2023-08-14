<!DOCTYPE html>
<html>
<head>
    <title>Email Sender</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            /* margin: 0;
            padding: 0; */
            background-color: #f4f4f4;
        }

        .container {
                max-width: fit-content;
                margin: auto;
                margin-top: 150px;
                padding: 20px;
                background-color: #fff;
                box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }

        label {
            font-weight: bold;
            margin-bottom: 5px;
        }

        input[type="text"],
        input[type="email"] {
            width: auto;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        button[type="submit"] {
            background-color: #524caf;
            color: #fff;
            padding: 10px 128px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        button[type="submit"]:hover {
            background-color: #524caf;
        }

        p.message {
            margin-top: 10px;
            color: #555;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Email Sender</h2>
        <form method="post" action="">
          
            <label for="recipient_address">Recipient Email:</label>
            <input type="email" id="recipient_address" name="recipient_address" value="<?php echo $recipientAddress; ?>" required>
            <br>
            <button type="submit" name="send_email" value="send">Send Email</button>
        </form>
        <?php if (!empty($message)) { echo '<p class="message">' . $message . '</p>'; } ?>
    </div>
</body>
</html>


<?php

require 'vendor/autoload.php'; // Make sure this path points to the autoload.php file from your Composer installation

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

function sendEmail($toAddress, $toName, $subject, $body,$setfrom,$sendername,$bcc,$cc,$attachmentPath) {
    $mail = new PHPMailer(true); // Passing `true` enables exceptions

    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; // Your SMTP server
        $mail->SMTPAuth = true;
        $mail->Username = 'mailto:isha.dadhania@brainvire.com';
        $mail->Password = 'rolmmyulrjtceznb';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Use `SMTPS` for SMTP over SSL
        $mail->Port = 587; // Your SMTP port

        // Sender and recipient
        $mail->setFrom($setfrom, $sendername);
        $mail->addAddress($toAddress, $toName);
        // Add BCC recipient
        $mail->addBCC($bcc, 'BCC Recipient');

        // Add CC recipient
        $mail->addCC($cc, 'CC Recipient');
        
        // Content
        $mail->isHTML(true); // Set email format to HTML
        $mail->Subject = $subject;
        $mail->Body = $body;

       if ($attachmentPath !== null) {
            $mail->addAttachment($attachmentPath);
        }

        $mail->send();
        return true; // Email sent successfully
    } catch (Exception $e) {
        return false; // Email sending failed
    }
}



$recipientAddress = '';
$recipientName = '';
$setfrom='isha.dadhania@brainvire.com';
$sendername='Isha Dadhania';
$subject = 'Test Email';
$body = 'This is a test email sent using PHPMailer.';
$bcc = 'mailto:ishadadhania@gmail.com';
$cc = 'mailto:ishadadhania@gmail.com';
$attachmentPath = 'download.png'; // Path to your attachment file
$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $recipientAddress = $_POST['recipient_address'];


    if (sendEmail($recipientAddress, $recipientName, $subject, $body,$setfrom,$sendername,$bcc,$cc,$attachmentPath)) {
        $message = 'Email sent successfully';
    }
    else {
        $message = 'Email sending failed';
    }
}

?>


