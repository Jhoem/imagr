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
        if (!$this->isAllowedDimensions($width, $height)) {
            return false;
        }

        $this->width = $width;
        $this->height = $height;

        return $this->clear();
    }

    public function setCanvas($canvas)
    {
        if ($this->isAllowedDimensions(sizeof($canvas[0]), sizeof($canvas))) {
            return false;
        }

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

    public function dot($x, $y, $color)
    {
        if (!$this->isInRange($x, $y)) {
            return false;
        }

        $this->canvas[$y-1][$x-1] = $color;
    }

    public function horizontalFill($row, $x1, $x2, $color)
    {
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
            $this->dot($x1, $row, $color);
        }

        return true;
    }

    public function verticalFill($column, $y1, $y2, $color)
    {
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
            $this->dot($column, $y1, $color);
        }

        return true;
    }

    public function colorFill()
    {
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

    private function isAllowedDimensions($width = false, $height = false)
    {
        $width = $width ?: $this->width;
        $height = $height ?: $this->height;

        return ($this->isAllowedWidth($width, $this->MIN_WIDTH, $this->MAX_WIDTH)
            && $this->isAllowedHeight($height, $this->MIN_HIEGHT, $this->MAX_HIEGHT));
    }

    private function isInRange($height, $width) {
        return ($this->isAllowedWidth($height, $this->MIN_WIDTH, $this->width)
            && $this->isAllowedHeight($height, $this->MIN_HIEGHT, $this->height));
    }

    private function isAllowedWidth($width, $minWidth, $maxWidth) {

        return ($width >= $minWidth && $width <= $maxWidth);
    }

    private function isAllowedHeight($height, $minHeight, $maxHeight) {
        return ($height >= $minHeight && $height <= $maxHeight);
    }
}
