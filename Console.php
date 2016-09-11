<?php
require './Library/Editor.php';

use Library\Editor;

class Console
{
    private $editor;
    private $allowedCommands;

    public function __construct()
    {
        $this->editor = new Editor;
        $this->allowedCommands = [
            'I' => 'create', /* */
            'C' => 'clear',
            'L' => 'setDotColor',
            'V' => 'verticalFill',
            'H' => 'horizontalFill',
            'F' => 'colorFill',
            'S' => 'showImage',
            'X' => 'exit',
        ];
    }

    public function start()
    {
        $this->printn(array_keys($this->allowedCommands));
        $this->printn('Starting console.');
        $this->readCommand();
        $this->printn('Closing console.');

        exit;
    }

    private function readCommand()
    {
        echo '> ';

        $str = fopen ('php://stdin', 'r');
        $line = fgets($str);
        $command_args = explode(' ', trim(preg_replace('/\s+/', ' ', $line)));
        $command = array_shift($command_args);

        if ($command === 'X') {
            exit;
        }

        // $this->printn($command);
        // $this->printn($command_args);

        if (!in_array($command, array_keys($this->allowedCommands))) {
            $this->printn($this->editor->command . ' is not a valid command');
        } else {
            $function = $this->allowedCommands[$command];
            $this->editor->$function(...$command_args);
        }

        return $this->readCommand();
    }

    public function printn($var)
    {
        echo (is_array($var) ? json_encode($var, JSON_PRETTY_PRINT) : $var). PHP_EOL;
    }
}

$console = new Console;
$console->start();
