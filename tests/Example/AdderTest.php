<?php
declare(strict_types=1);

namespace Tests\Example;

use PHPStartup\Example\Adder;
use PHPUnit\Framework\TestCase;

class AdderTest extends TestCase {
    public function addingTestCases()
    {
        return [
            [0, 1, 1],
            [2, 3, 5],
            [0, 0, 0],
        ];
    }

    /**
     * @dataProvider addingTestCases
     */
    public function testCanAdd($x, $y, $expected)
    {
        $adder = new Adder();
        $this->assertSame($expected, $adder->add($x, $y));
    }
}