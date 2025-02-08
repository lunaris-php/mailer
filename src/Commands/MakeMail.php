<?php

    namespace Lunaris\Mailer\Commands;

    use Lunaris\Mailer\Utils\Template;

    class MakeMail {
        private string $path;
        private array $args;

        public function __construct(string $path, array $args) {
            $this->path = $path;
            $this->args = $args;
        }

        public function execute(): void {
            $args = Template::getArgs($this->args);
            $mailName = $args['name'];
            $moduleName = $args['module'] ?? 'Main';

            $content = Template::mail($moduleName, $mailName);
            $modulePath = $this->path . "/src/modules/" . $moduleName;
            $mailFolderPath = $this->checkMailsFolder($modulePath);
            if($mailFolderPath) {
                $this->generate($mailName, $content, $mailFolderPath);
            }
        }

        private function checkMailsFolder($modulePath) {
            $folderPath = $modulePath . "/Mails";

            if(!is_dir($folderPath)) {
                if(mkdir($folderPath, 0777, true)) {
                    echo "Mails folder has been created in {$modulePath}." . PHP_EOL;
                } else {
                    echo "Failed to create Mails folder in {$modulePath}." . PHP_EOL;
                    return false;
                }
            }

            return $folderPath;
        }

        private function generate($name, $content, $path) {
            $mailFileName = $name . ".php";
            $mailFilePath = $path . "/" . $mailFileName;
            if(file_exists($mailFilePath)) {
                echo "{$name} already exists in {$path}" . PHP_EOL;
                return false;
            }

            file_put_contents($mailFilePath, $content);

            echo $name . " has been created in " . $path . PHP_EOL;
        }
    }