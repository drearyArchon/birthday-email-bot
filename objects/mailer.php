<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'C:\xampp\composer\vendor\autoload.php';

class Mailer{

    /** SET UP OBJECT PROPERTIES **/

    /** SMTP CURRENTLY USES MAILTRAP FOR TESTING PURPOSES **/
    /** PRODUCTION VERSION SHOULD CHANGE CREDENTIALS TO CONNECT TO BUSINESS SMTP SERVER INSTEAD **/
    private $smtp_host = "smtp.mailtrap.io";
    private $smtp_auth = true;
    private $smtp_port = 2525;
    private $smtp_username = "63f67137c0dace";
    private $smtp_password = "b18de358f3bb9f";

    private $bot_email = "happybirthday@sayakaya.com";
    private $bot_name = "Birthday Bot Sayakaya";

    public $mailer;

    public $recipient_email;
    public $recipient_name;
    public $subject;
    public $body;

    public function getMailer(){
        $this->mailer = new PHPMailer(TRUE);
        return $this->mailer;
    }

    public function send(){
        /** SENDS THE EMAIL THROUGH THE SMTP SERVER **/
        /** ALL FIELDS SHOULD BE FILLED OUT BEFORE MAIL CAN BE SENT **/
        try{
            $this->mailer->setFrom($this->bot_email, $this->bot_name);
            $this->mailer->isHTML(TRUE);
            $this->mailer->addAddress($this->recipient_email, $this->recipient_name);
            $this->mailer->Subject = $this->subject;
            $this->mailer->Body = $this->body;
            $this->mailer->isSMTP();
            $this->mailer->Host = $this->smtp_host;
            $this->mailer->SMTPAuth = $this->smtp_auth;
            $this->mailer->Port = $this->smtp_port;
            $this->mailer->Username = $this->smtp_username;
            $this->mailer->Password = $this->smtp_password;         
            $this->mailer->send();    
        } catch (Exception $e) {
            /* PHPMailer exception. */
            echo $e->errorMessage();
        } catch (\Exception $e) {
            /* PHP exception (note the backslash to select the global namespace Exception class). */
            echo $e->getMessage();
        }
    }
}
?>