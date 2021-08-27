<?php

namespace Entities\Cards\Tests\Controller;

use Entities\Cards\Classes\Cards;
use PHPUnit\Framework\TestCase;

class CardTest extends TestCase
{
    public function testSuccess() : void
    {
        $card = new Cards();
        $cardResult = $card->getById(1);

        $this->assertEquals(true, true);
    }
}