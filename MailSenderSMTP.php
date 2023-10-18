<?php

namespace Soudurelaser\Service\Mail;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;


/**
 * Classe MailSenderSMTP
 *
 * Cette classe simplifie l'envoi d'e-mails en utilisant le protocole SMTP
 * avec la bibliothèque PHPMailer.
 */


class MailSenderSMTP
{

    /**
     * @var PHPMailer Instance de PHPMailer
     */
    private $mail;

    /**
     * Constructeur de la classe MailSenderSMTP.
     *
     * @param string $smtp_server_host   Adresse du serveur SMTP.
     * @param string $srcEmail          Adresse e-mail de l'expéditeur.
     * @param string $srcName           Nom de l'expéditeur.
     * @param string $srcAppPassword    Mot de passe de l'application de l'expéditeur.
     * @param string $dstEmail          Adresse e-mail du destinataire.
     * @param string $dstName           Nom du destinataire.
     * @param string $subject           Sujet de l'e-mail.
     * @param string $htmlBody          Corps de l'e-mail en HTML.
     * @param string $altBody           Corps de l'e-mail en texte brut (optionnel).
     */

    function __construct($smtp_server_host, $srcEmail, $srcName, $srcAppPassword, $dstEmail, $dstName,  $subject, $htmlBody, $altBody="") {

        $this->mail = new PHPMailer(true);

        //$mail->SMTPDebug = SMTP::DEBUG_SERVER; // Enable verbose debug output
        $this->mail->isSMTP(); // Send using SMTP
        $this->mail->Host = $smtp_server_host; // Set the SMTP server to send through
        $this->mail->SMTPAuth = true; // Enable SMTP authentication
        /********************************************************************* */
        $this->mail->Username = $srcEmail; // Our Email(Sender)
        $this->mail->Password = $srcAppPassword; // The app password of our mail
        /********************************************************************* */
        $this->mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; // Enable TLS encryption, `PHPMailer::ENCRYPTION_STARTTLS` for TLS
        $this->mail->Port = 465; // TCP port to connect to (465 for SSL, 587 for TLS)

        $this->mail->setFrom($srcEmail, $srcName);
        $this->mail->addAddress($dstEmail, $dstName);
        $this->mail ->CharSet = "UTF-8"; 
        $this->mail->isHTML(true); // Set email format to HTML
        $this->mail->Subject = $subject;
        $this->mail->Body = $htmlBody;
        $this->mail->AltBody = $altBody;
    }

     /**
     * Méthode d'envoi d'e-mail.
     *
     * @return bool Retourne true en cas de succès, false en cas d'échec.
     */

    function send()
    {
        try {
            $this->mail->send();
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

}
