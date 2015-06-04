<?php

/**
 * This file is part of the Error package
 *
 * (c) InnovationGroup
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code
 */

namespace FivePercent\Component\Error;

/**
 * Errors testing
 *
 * @author Vitaliy Zhuk <zhuk2205@gmail.com>
 */
class ErrorsTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Base testing
     */
    public function testWithOneFactory()
    {
        $errors = new Errors();
        $errors->addFactory(new FirstErrorFactory());
        $errors->addFactory(new SecondErrorFactory());

        $codes = $errors->getErrors();
        $this->assertEquals([
            1  => 'Error #1',
            2  => 'Error #2',
            11 => 'Error #11',
            12 => 'Error #12'
        ], $codes);

        $exceptions = $errors->getExceptions();

        $this->assertEquals([
            'InvalidArgumentException' => 1,
            'RuntimeException'         => 2,
            'LogicException'           => 11
        ], $exceptions);

        // Success check reserved diapasons
        $errors->checkReservedCodes();

        // Success check has exception
        $this->assertTrue($errors->hasException(new \RuntimeException()));
        $this->assertFalse($errors->hasException(new \OutOfRangeException()));

        // Success get code by exception
        $this->assertEquals(11, $errors->getExceptionCode(new \LogicException()));
    }

    /**
     * Test for invalid reserved codes
     *
     * @expectedException \RuntimeException
     * @expectedExceptionMessage The reserved codes for factory "FivePercent\Component\Error\ThirdErrorFactoryWithInvalidReservedDiapason" [15 - 30] superimposed on "FivePercent\Component\Error\SecondErrorFactory" factory [10 - 19].
     */
    public function testWithInvalidReservedDiapason()
    {
        $errors = new Errors();
        $errors->addFactory(new FirstErrorFactory());
        $errors->addFactory(new SecondErrorFactory());
        $errors->addFactory(new ThirdErrorFactoryWithInvalidReservedDiapason());;

        $errors->checkReservedCodes();
    }
}

/**
 * Error factory #1 for testing
 */
class FirstErrorFactory implements ErrorFactoryInterface
{
    /**
     * {@inheritDoc}
     */
    public function getErrors()
    {
        return [
            1 => 'Error #1',
            2 => 'Error #2'
        ];
    }

    /**
     * {@inheritDoc}
     */
    public function getExceptions()
    {
        return [
            'InvalidArgumentException' => 1,
            'RuntimeException'         => 2
        ];
    }

    /**
     * {@inheritDoc}
     */
    public function getReservedDiapason()
    {
        return [1, 9];
    }
}

/**
 * Error factory #2 for testing
 */
class SecondErrorFactory implements ErrorFactoryInterface
{
    /**
     * {@inheritDoc}
     */
    public function getErrors()
    {
        return [
            11 => 'Error #11',
            12 => 'Error #12'
        ];
    }

    /**
     * {@inheritDoc}
     */
    public function getExceptions()
    {
        return [
            'LogicException' => 11
        ];
    }

    /**
     * {@inheritDoc}
     */
    public function getReservedDiapason()
    {
        return [10, 19];
    }
}

/**
 * Error factory #3 with invalid reserved diapasons for testing
 */
class ThirdErrorFactoryWithInvalidReservedDiapason implements ErrorFactoryInterface
{
    /**
     * {@inheritDoc}
     */
    public function getErrors()
    {
        return [];
    }

    /**
     * {@inheritDoc}
     */
    public function getExceptions()
    {
        return [];
    }

    /**
     * {@inheritDoc}
     */
    public function getReservedDiapason()
    {
        return [15, 30];
    }
}
