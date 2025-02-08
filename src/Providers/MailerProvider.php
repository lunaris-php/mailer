<?php

    namespace Lunaris\Mailer\Providers;

    class MailerProvider {
        public function getCommands() {
            return [
                "make:mail" => \Lunaris\Mailer\Commands\MakeMail::class
            ];
        }
    }