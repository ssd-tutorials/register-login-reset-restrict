<?php

namespace AppTest\Unit\Utilities;

use App\Utilities\Hash;
use AppTest\BaseCase;

class HashTest extends BaseCase
{
    /**
     * @test
     */
    public function correctly_makes_and_verifies_hash()
    {
        $hash = Hash::make('secret');

        $this->assertTrue(
            Hash::verify('secret', $hash),
            "Hash make / verify failed"
        );
    }
}