<?php
require_once 'vendor/autoload.php';

use Egulias\EmailValidator\EmailValidator;
use Egulias\EmailValidator\Validation\DNSCheckValidation;

if(isset($_POST['email'])) {
    $email = $_POST['email'];

    $validator = new EmailValidator();
    $isValid = $validator->isValid($email, new DNSCheckValidation());

    if ($isValid) {
        echo "Email address is valid: $email";
    } else {
        echo "Invalid email address: $email";
    }
}
?>
<form action="" method="post">
    <input type="text" name="email">
    <input type="submit">
</form>
