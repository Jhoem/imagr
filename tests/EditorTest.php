<?php
namespace Test;

use Library\Editor;
use PHPUnit\Framework\TestCase;

class EditorTest extends TestCase
{
    protected $editor;
    protected $clear = [
        ['O', 'O', 'O', 'O', 'O', 'O'],
        ['O', 'O', 'O', 'O', 'O', 'O'],
        ['O', 'O', 'O', 'O', 'O', 'O'],
        ['O', 'O', 'O', 'O', 'O', 'O'],
        ['O', 'O', 'O', 'O', 'O', 'O'],
        ['O', 'O', 'O', 'O', 'O', 'O'],
    ];

    protected function setUp()
    {
        $this->editor = new Editor;
        $this->editor->create(6, 6);
    }

    public function testCreate()
    {
        $this->assertSame($this->clear, $this->editor->showImage());
        $this->assertFalse($this->editor->create(251, 1));
        $this->assertFalse($this->editor->create(1, 251));
        $this->assertFalse($this->editor->create(251, 251));
        $this->assertFalse($this->editor->create(0, 1));
        $this->assertFalse($this->editor->create(1, 0));
        $this->assertFalse($this->editor->create(0, 0));
    }

    public function testClear()
    {
        $this->editor->clear();
        $this->assertSame($this->clear, $this->editor->showImage());
    }

    public function testSetDotColor()
    {
        $expected = [
            ['O', 'X', 'O', 'O', 'O', 'O' ],
            ['O', 'O', 'O', 'O', 'O', 'O' ],
            ['O', 'O', 'O', 'O', 'O', 'O' ],
            ['O', 'O', 'O', 'O', 'O', 'O' ],
            ['O', 'O', 'O', 'O', 'O', 'O' ],
            ['O', 'O', 'O', 'O', 'O', 'O' ],
        ];
        $this->editor->setDotColor(2, 1, 'X');
        $this->assertSame($expected, $this->editor->showImage());
    }

    public function testHorizontalFill()
    {
        $expected = [
            ['O', 'O', 'O', 'O', 'O', 'O' ],
            ['O', 'O', 'O', 'O', 'O', 'O' ],
            ['O', 'O', 'O', 'O', 'O', 'O' ],
            ['O', 'O', 'O', 'O', 'O', 'O' ],
            ['O', 'O', 'O', 'O', 'O', 'O' ],
            ['O', 'C', 'C', 'C', 'C', 'C' ],
        ];

        $this->editor->horizontalFill(6, 2, 6, 'C');
        $this->assertSame($expected, $this->editor->showImage());
        $this->editor->clear();
        $this->editor->horizontalFill(6, 2, 6, 'C');
        $this->assertSame($expected, $this->editor->showImage());
    }

    public function testVerticalFill()
    {
        $expected = [
            ['O', 'C', 'O', 'O', 'O', 'O' ],
            ['O', 'C', 'O', 'O', 'O', 'O' ],
            ['O', 'C', 'O', 'O', 'O', 'O' ],
            ['O', 'C', 'O', 'O', 'O', 'O' ],
            ['O', 'C', 'O', 'O', 'O', 'O' ],
            ['O', 'O', 'O', 'O', 'O', 'O' ],
        ];

        $this->editor->verticalFill(2, 1, 5, 'C');
        $this->assertSame($expected, $this->editor->showImage());
        $this->editor->clear();
        $this->editor->verticalFill(2, 5, 1, 'C');
        $this->assertSame($expected, $this->editor->showImage());
    }

    public function testColorFill()
    {
        $expected = [
            ['C', 'C', 'C', 'C', 'C', 'C' ],
            ['C', 'C', 'C', 'C', 'C', 'C' ],
            ['C', 'C', 'C', 'C', 'C', 'C' ],
            ['C', 'C', 'C', 'C', 'C', 'C' ],
            ['C', 'C', 'C', 'C', 'C', 'C' ],
            ['C', 'C', 'C', 'C', 'C', 'C' ],
        ];

        $custom = [
            ['O', 'O', 'O', 'O', 'O', 'F' ],
            ['O', 'O', 'O', 'O', 'F', 'O' ],
            ['O', 'O', 'O', 'F', 'O', 'O' ],
            ['O', 'O', 'F', 'O', 'O', 'O' ],
            ['O', 'F', 'O', 'O', 'O', 'O' ],
            ['F', 'O', 'O', 'O', 'O', 'O' ],
        ];

        $expected2 = [
            ['O', 'O', 'O', 'O', 'O', 'F' ],
            ['O', 'O', 'O', 'O', 'F', 'F' ],
            ['O', 'O', 'O', 'F', 'F', 'F' ],
            ['O', 'O', 'F', 'F', 'F', 'F' ],
            ['O', 'F', 'F', 'F', 'F', 'F' ],
            ['F', 'F', 'F', 'F', 'F', 'F' ],
        ];

        $this->editor->fillColor(6, 6, 'C');
        $this->assertSame($expected, $this->editor->showImage());
        $this->editor->setCanvas($custom);
        $this->editor->fillColor(4, 4, 'F');
        $this->assertSame($expected2, $this->editor->showImage());
    }

    public function testAll()
    {
        $expected = [
            ['G', 'G', 'G', 'G', 'G', 'F' ],
            ['G', 'H', 'H', 'H', 'A', 'F' ],
            ['G', 'G', 'G', 'F', 'A', 'F' ],
            ['G', 'G', 'F', 'F', 'A', 'F' ],
            ['G', 'F', 'F', 'F', 'A', 'F' ],
            ['F', 'F', 'F', 'F', 'A', 'F' ],
        ];

        $this->editor->fillColor(3, 4, 'G');
        $this->editor->setDotColor(1, 6, 'F');
        $this->editor->setDotColor(2, 5, 'F');
        $this->editor->setDotColor(3, 4, 'F');
        $this->editor->setDotColor(4, 3, 'F');
        $this->editor->setDotColor(5, 2, 'F');
        $this->editor->setDotColor(6, 1, 'F');
        $this->editor->fillColor(6, 6, 'F');
        $this->editor->horizontalFill(2, 5, 2, 'H');
        $this->editor->verticalFill(5, 2, 6, 'A');
        $this->assertSame($expected, $this->editor->showImage());
        $this->editor->clear();
        $this->assertSame($this->clear, $this->editor->showImage());
    }
}
