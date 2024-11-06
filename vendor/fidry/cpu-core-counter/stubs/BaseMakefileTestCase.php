<?php

/*
 * This file is part of the Fidry CPUCounter Config package.
 *
 * (c) Théo FIDRY <theo.fidry@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Fidry\Makefile\Test;

use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
class BaseMakefileTestCase extends TestCase
{
    public function test_dummy(): void
    {
        $this->addToAssertionCount(1);
    }
}
