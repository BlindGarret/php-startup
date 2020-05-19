<?php

declare(strict_types=1);

namespace Tests\Unit\Example;

use PHPStartup\Example\Adder;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 * @coversNothing
 */
class AdderTest extends TestCase
{
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
     *
     * @param mixed $x
     * @param mixed $y
     * @param mixed $expected
     */
    public function testCanAdd($x, $y, $expected)
    {
        $adder = new Adder();
        $this->assertSame($expected, $adder->add($x, $y));
    }
}
