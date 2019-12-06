<?php

/**
 * Cron job to be placed in the CronTab (runs every 24 hours)
 */
//0 0 * * * /usr/bin/php path/to/fetch-orders.php &> /dev/null

/**
 * fetch-orders.php contents
 * 
 */

/**
 * Demo MySQL credentials
 */
$db_user = "virson";
$db_pass = "jYuJPCLKRwrD2cLr";
$db_name = "virson";
$db_table = "orders";
$db_server = "127.0.0.1";

//Begin sql connection
$connection = mysqli_connect($db_server, $db_user, $db_pass, $db_table);
mysqli_select_db($connection, $db_name);

/**
 * Begin query
 * Assuming date is the column we want to filter
 */
$query = "SELECT * FROM $db_table WHERE date > DATE_SUB(NOW(), INTERVAL 1 DAY) ORDER BY date DESC;";
$query_p = mysqli_query($connection, $query);
$query_asoc = mysqli_fetch_assoc($query_p);

//Close connection
mysql_close($connection);

/**
 * Begin looping through all the orders
 */
//Container for our orders
$order_prices = [];
foreach($query_asoc as $order_item){
    $order_prices[] = $order_item['price'];
}

//Define total amount
$total_amount = array_sum($order_prices);

/**
 * Begin email notification
 * Uses the https://github.com/PHPMailer/PHPMailer as our mailer wrapper
 */
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Instantiation and passing `true` enables exceptions
$mail = new PHPMailer(true);

try {

    /**
     * ENV variables are from the .ENV file. please customize
     */

    //Server settings
    $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      // Enable verbose debug output
    $mail->isSMTP();                                            // Send using SMTP
    $mail->Host       = getenv('MAILER_HOST');                    // Set the SMTP server to send through
    $mail->SMTPAuth   = getenv('MAILER_SMTP_AUTH');                                   // Enable SMTP authentication
    $mail->Username   = getenv('MAILER_SMTP_USERNAME');                     // SMTP username
    $mail->Password   = getenv('MAILER_SMTP_PASSWORD');                               // SMTP password
    $mail->SMTPSecure = (getenv('MAILER_SMTP_SECURE') == 'ENCRYPTION_STARTTLS') ? PHPMailer::ENCRYPTION_STARTTLS : PHPMailer::ENCRYPTION_SMTPS; // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` also accepted
    $mail->Port       = 587;                                    // TCP port to connect to

    //Recipients
    $mail->setFrom(getenv('MAILER_FROM'), 'Mailer');
    $mail->addAddress('director@companyname.com');     // Add a recipient

    // Content
    $mail->isHTML(true);                                  // Set email format to HTML
    $mail->Subject = 'Customer Orders as of ' . date('F j, Y');

    //Begin object buffer
    ob_start();
    ?>
    <table>
        <thead>
            <tr>
                <th>Qty</th>
                <th>Unit Price</th>
                <th>Description</th>
                <th>Amount</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($query_asoc as $order): ?>
            <tr>
                <td><?php echo $order['qty'] ?></td>
                <td><?php echo $order['unit'] ?></td>
                <td><?php echo $order['description'] ?></td>
                <td><?php echo $order['price'] ?> PHP</td>
            </tr>
            <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr>
                <td>Total Amount</td>
                <td></td>
                <td></td>
                <td><?php echo $total_amount; ?> PHP</td>
            </tr>
        </tfoot>
    </table>
    <?php
    $order_html = ob_get_clean();

    $mail->Body = $order_html;
    $mail->send();

    //return 'Email has been sent';

} catch (Exception $e) {
    //return "Email could not be sent. Mailer Error: {$mail->ErrorInfo}";
}