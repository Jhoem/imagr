<?php
use \Library\Editor;

class Console
{
    private $editor;
    private $allowedCommands;

    public function __construct()
    {
        $this->editor = new Editor();
        $this->allowedCommands = [
            'I' => 'create', /* */
            'C' => 'clear',
            'L' => 'dot',
            'V' => 'verticalFill',
            'H' => 'horizontalFill',
            'F' => 'colorFill',
            'S' => 'showImage',
            'X' => 'exit',
        ];
    }

    public function start()
    {
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

        if ($command === 'x') {
            return;
        }

        $this->printn($command_args);

        $this->editor->command = $command;

        if (!in_array($this->editor->command, $this->allowedCommands)) {
            $this->printn($this->editor->command . ' is not a valid command');
        } else {
            $this->printn($this->$allowedCommands[$command]($command_args));
        }

        return $this->readCommand();
    }

    public function printn($var)
    {
        echo (is_array($var) ? json_encode($var, JSON_PRETTY_PRINT) : $var). PHP_EOL;
    }

    public function test($default = 'me') {
        echo $default;
    }
}

$console = new Console;
$console->start();
