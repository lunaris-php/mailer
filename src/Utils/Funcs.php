<?php

    namespace Lunaris\Mailer\Utils;

    use Exception;

    class Funcs {
        public static function view($path, $options = []) {
            $module = $options['module'] ?? 'Main';
            $args = $options['args'] ?? [];
            $path = str_replace(".", "/", $path);
            $root = dirname(getcwd());
            $viewPath = $root . "/src/modules/" . $module . "/views/" . $path . ".php";
            if (!file_exists($viewPath)) {
                throw new Exception("View file not found: {$viewPath}");
            }
            extract($args);
            ob_start();
            include($viewPath);
            $var=ob_get_contents(); 
            ob_end_clean();
            return $var;
        }
    }