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
            'I' => [
                'create',
                2,
                'I M N - Create a new M x N image with all pixels coloured white (O).'
            ],

            'C' => [
                'clear',
                0,
                'C - Clears the table, setting all pixels to white (O).'],

            'L' => [
                'setDotColor',
                3,
                'L X Y C - Colours the pixel (X, Y) with colour C.'],

            'V' => [
                'verticalFill',
                4,
                'V X Y1 Y2 C - Draw a vertical segment of colour C in column X between rows Y1 and Y2.'],

            'H' => [
                'horizontalFill',
                4,
                'H X1 X2 Y C - Draw a horizontal segment of colour C in row Y between columns X1 and X2.'],

            'F' => [
                'fillColor',
                3,
                'F X Y C - Fill the region R with the colour C. R is defined as:
                Pixel (X, Y) belongs to R. Any other pixel which is the same colour as (X, Y) and shares a common side with any pixel in R also belongs to this region.',
            ],

            'S' => [
                'showImage',
                0,
                'S - Show the contents of the current image'],

            'X' => [
                'exit',
                0,
                'X - Terminate the session'],
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

        if ($command === 'X') {
            return;
        }

        if ($command === 'H') {
            $this->showCommands();

            return $this->readCommand();
        }

        if (!in_array($command, array_keys($this->allowedCommands))) {
            $this->printn($command . ' is not a valid command');
        } else {
            $function = $this->allowedCommands[$command][0];

            if (sizeof($command_args) <  $this->allowedCommands[$command][1]) {
                $this->printn('You are missing 1 or more parameters for this command');

                return $this->readCommand();
            }

            $this->editor->$function(...$command_args);
        }

        return $this->readCommand();
    }

    public function printn($var)
    {
        echo (is_array($var) ? json_encode($var, JSON_PRETTY_PRINT) : $var). PHP_EOL;
    }

    public function showCommands() {
        $this->printn('Commands: ');

        foreach ($this->allowedCommands as $description) {
            $this->printn($description[2]);
        }
    }
}

$console = new Console;
$console->start();
