<?php
namespace Library;

class Editor
{
    private $defaultColor = 'O';
    private $color;
    private $canvas;
    private $height;
    private $width;

    public function __construct()
    {
        $this->canvas = [];
    }

    public function create($height, $width)
    {
        if (!$this->isAllowedDimensions($height, $width)) {
            return 'The dimensions passed exceeds the maximum allowed dimensions';
        }

        $row = [];

        for ($i=0; $i<$width; $i++) {
            array_push($row, $this->defaultColor);
        }

        for ($i=0; $i<$height; $i++) {
            array_push($this->canvas, $row);
        }
    }

    public function clear()
    {
    }

    public function dot()
    {

    }

    public function horizontalFill()
    {
    }

    public function verticalFill()
    {
    }

    public function colorFill()
    {
    }

    public function showImage()
    {
        echo json_encode($this->canvas, JSON_PRETTY_PRINT);

        return $this->canvas;
    }

    private function isAllowedDimensions($height = false, $width = false)
    {
        $height = $height ?: $this->height;
        $width = $width ?: $this->width;

        return ($height <= 250 && $width <= 250);
    }
}
