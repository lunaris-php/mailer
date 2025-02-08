<?php

    namespace Luanris\Mailer\Exceptions;

    use Exception;

    class MailNotSentException extends Exception {
        private $message;

        public function __construct($message="") {
            $message = "Error occured while sending mail :: " . $message;
            parent::__construct($message);
            $this->message = $message;
        }

        public function getErrorMessage() {
            return $this->message;
        }
    }