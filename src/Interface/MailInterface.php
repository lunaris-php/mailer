<?php

    namespace Lunaris\Mailer\Interface;

    interface MailInterface {
        public function handle(array $args): void;
    }