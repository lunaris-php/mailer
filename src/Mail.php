<?php

    namespace Lunaris\Mailer;

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception as MailerException;
    use Exception;
    use Lunaris\Mailer\Utils\Funcs;

    class Mail {
        protected $mailer;

        public function __construct() {
            $this->mailer = new PHPMailer(true);
            $this->config();
            $this->mailer->isHTML(true);
        }

        private function config() {
            $root = dirname(getcwd());
            $config = $root . '/app/config/app.php';

            echo $config . PHP_EOL;

            $this->mailer->isSMTP();
            $this->mailer->Host = $config['mail_server'];
            $this->mailer->SMTPAuth = true;
            $this->mailer->Username = $config['mail_username'];
            $this->mailer->Password = $config['mail_password'];
            $this->mailer->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $this->mailer->Port = $config['mail_port'];
            $this->mailer->setFrom($config['mail_from_address'], $config['mail_from_name']);
        }

        protected function receiver(string $email, string $name = '') {
            $this->mailer->addAddress($email, $name);
        }

        protected function subject(string $text) {
            $this->mailer->Subject = $text;
        }

        protected function content(string $view, array $args, string $module = "Main") {
            $this->mailer->Body = Funcs::view($view, [
                "args" => $args,
                "module" => $module
            ]);
        }

        public function send() {
            try {
                $this->mailer->send();
            } catch(MailerException $e) {
                throw new Exception("Message could not be sent. Mailer Error: {$this->mailer->ErrorInfo}");
            }
        }
    }