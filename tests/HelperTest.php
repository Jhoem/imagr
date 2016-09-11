<?php
namespace Test;

use Library\Editor;
use PHPUnit\Framework\TestCase;

class HelperTest extends TestCase
{
    protected function setUp()
    {
        $this->editor = new Editor;
        $this->editor->create(10, 10);
    }

    public function testIsAllowedDimensions()
    {
        $this->assertTrue($this->editor->isAllowedDimensions(1,1));
        $this->assertTrue($this->editor->isAllowedDimensions(250,250));
        $this->assertFalse($this->editor->isAllowedDimensions(-1,1));
        $this->assertFalse($this->editor->isAllowedDimensions(1,-1));
        $this->assertFalse($this->editor->isAllowedDimensions(-1,-1));
        $this->assertFalse($this->editor->isAllowedDimensions(1,251));
        $this->assertFalse($this->editor->isAllowedDimensions(251,1));
        $this->assertFalse($this->editor->isAllowedDimensions(251,251));
    }

    public function testIsInRange() {
        $this->assertTrue($this->editor->isInRange(1,1));
        $this->assertTrue($this->editor->isInRange(10,10));
        $this->assertFalse($this->editor->isInRange(-1,10));
        $this->assertFalse($this->editor->isInRange(10,-1));
        $this->assertFalse($this->editor->isInRange(-1,-1));
        $this->assertFalse($this->editor->isInRange(11,10));
        $this->assertFalse($this->editor->isInRange(10,11));
        $this->assertFalse($this->editor->isInRange(11,11));
    }
}
