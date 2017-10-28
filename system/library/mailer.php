<?php

class Mailer {
    public  $subject = null;
    public  $body    = null;
    public  $altbody = null;
    private $mailer = null;

    public function __get($property)
    {
        if (property_exists($this, $property)) {
            return $this->$property;
        }
    }

    public function __set($property, $value)
    {
        if (property_exists($this, $property)) {
            $this->$property = $value;
        }

        return $this;
    }


    public function __construct() {
        $this->mailer = new PHPMailer\PHPMailer\PHPMailer(true);
        $this->mailer->isSMTP();
        $this->mailer->isHTML(true);
        $this->mailer->Host = SMTP_SERVER;
        $this->mailer->SMTPAuth = true;
        $this->mailer->Username = SMTP_USERNAME;
        $this->mailer->Password = SMTP_PASSWORD;
        $this->mailer->SMTPSecure = 'tls';
        $this->mailer->Port = SMTP_PORT;

    }


    public function send($email){
        try {
            $this->mailer->addAddress($email);
            $this->mailer->addReplyTo(SMTP_REPLYTO, SMTP_NAME);
            $this->mailer->setFrom(SMTP_REPLYTO, SMTP_NAME);
            $this->mailer->Subject = $this->subject;
            $this->mailer->Body = $this->body;
            $this->mailer->Altbody = $this->altbody;
            $methods = get_class_methods($this->mailer);
            print_r($methods);
            $result = $this->mailer->send();
            echo "<pre>" . $result . "</pre>";
            exit();
            return $this->mailer->send();
        } catch (Exception $e) {
            echo "Mailer error: " . $this->mailer->ErrorInfo;
        }
    }
}
