<?php
namespace Library;

class Editor
{
    private $DEFAULT_COLOR = 'O';
    private $MIN_HIEGHT = 1;
    private $MAX_HIEGHT = 250;
    private $MIN_WIDTH = 1;
    private $MAX_WIDTH = 250;

    private $canvas;
    private $height;
    private $width;

    public function __construct()
    {
        $this->canvas = [];
    }

    public function create($width, $height)
    {
        $validation = $this->isValidParameters([
            'width' => [$width, 'number'],
            'height' => [$height, 'number']
        ]);

        if (is_string($validation)) {
            echo $validation;

            return false;
        }

        if (!$this->isAllowedDimensions($width, $height)) {
            return false;
        }

        $this->width = $width;
        $this->height = $height;

        return $this->clear();
    }

    public function setCanvas($canvas)
    {
        if (!$this->isAllowedDimensions(sizeof($canvas[0]), sizeof($canvas))) {
            return false;
        }

        $this->canvas = [];
        $this->canvas = $canvas;

        return true;
    }

    public function clear()
    {
        if (!$this->isAllowedDimensions()) {
            return false;
        }

        $this->canvas = [];
        $row = [];

        for ($i=0; $i<$this->width; $i++) {
            array_push($row, $this->DEFAULT_COLOR);
        }

        for ($i=0; $i<$this->height; $i++) {
            array_push($this->canvas, $row);
        }

        return true;
    }

    public function setDotColor($x, $y, $color)
    {
        $validation = $this->isValidParameters([
            'X' => [$x, 'number'],
            'Y' => [$y, 'number'],
            'color' => [$color, 'letter']
        ]);

        if (is_string($validation)) {
            echo $validation;

            return false;
        }

        if (!$this->isInRange($x, $y)) {
            return false;
        }

        $this->canvas[$y-1][$x-1] = strtoupper($color);

        return $this->canvas;
    }

    public function getDotColor($x, $y)
    {
        if (!$this->isInRange($x, $y)) {
            return false;
        }

        return $this->canvas[$y-1][$x-1];
    }

    public function horizontalFill($x1, $x2, $row, $color)
    {
        $validation = $this->isValidParameters([
            'X1' => [$x1, 'number'],
            'X2' => [$x2, 'number'],
            'row' => [$row, 'number'],
            'color' => [$color, 'letter']
        ]);

        if (is_string($validation)) {
            echo $validation;

            return false;
        }

        if (!($this->isAllowedHeight($x1, 1, $this->height)
            && $this->isAllowedHeight($x2, 1, $this->height))) {
                return false;
        }

        if ($x1 > $x2) {
            $temp = $x1;
            $x1 = $x2;
            $x2 = $temp;
        }

        for ($x1; $x1 <= $x2; $x1++) {
            $this->setDotColor($x1, $row, $color);
        }

        return true;
    }

    public function verticalFill($column, $y1, $y2, $color)
    {
        $validation = $this->isValidParameters([
            'column' => [$column, 'number'],
            'Y1' => [$y1, 'number'],
            'Y2' => [$y2, 'number'],
            'color' => [$color, 'letter']
        ]);

        if (is_string($validation)) {
            echo $validation;

            return false;
        }

        if (!($this->isAllowedHeight($y1, 1, $this->height)
            && $this->isAllowedHeight($y2, 1, $this->height))) {
                return false;
        }

        if ($y1 > $y2) {
            $temp = $y1;
            $y1 = $y2;
            $y2 = $temp;
        }


        for ($y1; $y1 <= $y2; $y1++) {
            $this->setDotColor($column, $y1, $color);
        }

        return true;
    }

    public function fillColor($x, $y, $newColor, $originalColor = false)
    {
        $validation = $this->isValidParameters([
            'X' => [$x, 'number'],
            'Y' => [$y, 'number'],
            'color' => [$newColor, 'letter']
        ]);

        if (is_string($validation)) {
            echo $validation;

            return false;
        }

        if (!($this->isInRange($x, $y))) {
            return false;
        }

        $color = $this->getDotColor($x, $y);

        if (!$originalColor) {
            $originalColor = $color;
        }

        if ($color === $newColor){
            return false;
        }

        if ($color !== $originalColor){
            return false;
        }



        $this->setDotColor($x, $y, $newColor);

        $this->fillColor($x-1, $y, $newColor, $originalColor); //Left
        $this->fillColor($x, $y-1, $newColor, $originalColor); //Top
        $this->fillColor($x+1, $y, $newColor, $originalColor); //Right
        $this->fillColor($x, $y+1, $newColor, $originalColor); //Bottom
    }

    public function showImage()
    {
        foreach ($this->canvas as $row) {
            foreach ($row as $color) {
                echo $color;
            }
            echo PHP_EOL;
        }

        return $this->canvas;
    }

    public function isAllowedDimensions($width = false, $height = false)
    {
        $width = $width ?: $this->width;
        $height = $height ?: $this->height;

        $isAllowed = ($this->isAllowedWidth($width, $this->MIN_WIDTH, $this->MAX_WIDTH)
            && $this->isAllowedHeight($height, $this->MIN_HIEGHT, $this->MAX_HIEGHT));

        if (!$isAllowed) {
            echo "Parameters must be within the allowed width and height." . PHP_EOL;
        }

        return $isAllowed;
    }

    public function isInRange($width, $height) {
        return ($this->isAllowedWidth($width, $this->MIN_WIDTH, $this->width)
            && $this->isAllowedHeight($height, $this->MIN_HIEGHT, $this->height));
    }

    public function isAllowedWidth($width, $minWidth, $maxWidth) {
        return ($width >= $minWidth && $width <= $maxWidth);
    }

    public function isAllowedHeight($height, $minHeight, $maxHeight) {
        return ($height >= $minHeight && $height <= $maxHeight);
    }

    public function isValidParameters($parameters) {
        $invalidParameters = [];

        foreach ($parameters as $field => $values) {
            switch ($values[1]) {
                case 'number':
                    if (!is_numeric($values[0])) {
                        $invalidParameters[$field] = $values[1];
                    }
                    break;
                case 'letter':
                    if (!ctype_alpha($values[0])) {
                        $invalidParameters[$field] = $values[1];
                    }
                    break;
                default:
                    $invalidParameters[$field] = $values[1];
                    break;
            }
        }

        if (sizeof($invalidParameters)) {
            return $this->toString($invalidParameters);
        }

        return true;
    }

    public function toString($array) {
        $result = '';

        foreach ($array as $key => $value) {
            $result .= ($key . ' must be a ' . $value . PHP_EOL);
        }

        return $result;
    }
}
