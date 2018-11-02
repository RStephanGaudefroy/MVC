<?php

/**
 * Class mail
 * Construct, initialize and send a mail
 * Use mail php function
 */

namespace Core;

class Mail
{
    private $to;
    private $subject;
    private $message;
    private $headers;
    
    public function __construct(string $to, string $subject, string $message)
    {
        //echo $to, $subject, $message;
        $this->setTo($to);
        $this->setSubject($subject);
        $this->setMessage($message);
        $this->setHeaders();

        $this->sendMail();
    }

    /** SETTERS */
    private function setTo($to)
    {
        $this->to = $to;
    }

    private function setSubject($subject)
    {
        $this->subject = $subject;
    }

    private function setMessage($message)
    {
        $this->message = $message;
    }

    private function setHeaders()
    {
        $this->headers = "MIME-Version: 1.0"                           ."\r\n";
        $this->headers .="Content-type: text/html; charset=utf-8"      ."\r\n";
        $this->headers .="X-Mailer: PHP/". PHP_VERSION ."\r\n";
        $this->headers .="From: stephan.gaudefroy@gmail.com"               ."\r\n";
    }

    /** GETTERS */
    private function getTo()
    {
        return $this->to;
    }

    private function getSubject()
    {
        return $this->subject;
    }

    private function getMessage()
    {
        return $this->message;
    }

    private function getHeaders()
    {
        return $this->headers;
    }

    /**
     * SendMail
     * Init, construct and send mail
     */
    private function sendMail() 
    {
        ini_set("sendmail_from", "s.gaudefroy@orange.fr");

        var_dump (mail(
            $to = $this->getTo(),
            $subject = $this->getSubject(),
            $message = $this->getMessage(),
            $headers = $this->getHeaders()
        ) );
    }
}
