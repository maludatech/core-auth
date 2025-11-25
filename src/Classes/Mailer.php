<?php

declare(strict_types=1);

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once __DIR__ . '/../../vendor/autoload.php';

class Mailer
{
    private $mailer;

    public function __construct()
    {
        $config = require __DIR__ . '/../config/mail.php';

        $mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->Host       = $config["host"];
        $mail->SMTPAuth   = true;
        $mail->Username   = $config["username"];
        $mail->Password   = $config["password"];
        $mail->Port       = $config["port"];
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;

        $mail->setFrom($config["from_email"], $config["from_name"]);
        $mail->isHTML(true);

        $this->mailer = $mail;
    }

    public function send($to, $subject, $body)
    {
        try {
            $this->mailer->clearAddresses();
            $this->mailer->addAddress($to);
            $this->mailer->Subject = $subject;
            $this->mailer->Body = $body;

            return $this->mailer->send();
        } catch (Exception $e) {
            error_log("Mailer Error: " . $e->getMessage());
            return false;
        }
    }
}
