<?php
/*
 * Created 14.10.2019 10:16
 */

namespace ITTech\APP;

/**
 * Class eMail
 * @package ITTech\crm\Core
 * @author Alexandr Pokatskiy
 * @copyright ITTechnology
 */
class eMail
{
    /**
     * @var string Encoding
     */
    protected $encoding = "utf-8";

    /**
     * @var string|null Return address
     */
    protected $From = null;

    /**
     * @var string|null Message subject
     */
    protected $subject = null;

    /**
     * @var string|null Recipient
     */
    protected $to = null;

    /**
     * eMail constructor.
     * @param string $to Recipient
     * @param string $subject Message subject
     */
    public function __construct(string $to, string $subject)
    {
        $this->to      = $to;
        $this->subject = $subject;
        $this->From    = "webmaster@".$_SERVER["HTTP_HOST"];
    }

    /**
     * Set character encoding
     * @param string $encoding
     */
    public function encoding(string $encoding): void
    {
        $this->encoding = $encoding;
    }

    /**
     * Set Sender
     * @param string $from
     */
    public function from(string $from): void
    {
        $this->From = $from;
    }

    /**
     * send a message
     * @param string $message
     * @return bool
     */
    public function send(string $message): bool
    {
        $header = "Content-type:text/html; charset=".$this->encoding." \r\n";
        $header .= "From: ".$this->From;

        return mail($this->to, $this->subject, $message, $header);
    }
}
