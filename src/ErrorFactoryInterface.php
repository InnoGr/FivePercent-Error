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
 * All error factories should be implemented of this interface
 *
 * @author Vitaliy Zhuk <zhuk2205@gmail.com>
 */
interface ErrorFactoryInterface
{
    /**
     * Get available errors. Must be return array, when:
     * key - error code
     * value - error message
     *
     * @return array
     */
    public function getErrors();

    /**
     * Get exceptions. Must be return array, when:
     * key - exception class
     * value - error code
     *
     * @return array
     */
    public function getExceptions();

    /**
     * Get reserved diapason
     *
     * @return array
     */
    public function getReservedDiapason();
}
