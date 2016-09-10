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
    protected $expected = [
        ['C', 'C', 'C', 'C', 'C', 'C' ],
        ['C', 'X', 'X', 'X', 'X', 'X' ],
        ['C', 'X', 'C', 'C', 'C', 'C' ],
        ['C', 'X', 'C', 'C', 'X', 'C' ],
        ['C', 'X', 'C', 'X', 'C', 'C' ],
        ['C', 'C', 'C', 'C', 'C', 'C' ],
    ];

    protected function setUp()
    {
        $this->editor = new Editor;
    }

    public function testCreate()
    {
        $this->editor->create(6, 6);

        $this->assertSame($this->clear, $this->editor->showImage());
    }

    public function testClear()
    {

        $this->assertSame($this->clear, []);
    }

    public function testHorizontalFill()
    {
        $this->assertSame($this->expected, []);
    }

    public function testVerticalFill()
    {
        $this->assertSame($this->expected, []);
    }

    public function testColorFill()
    {
        $this->assertSame($this->expected, []);
    }
}
