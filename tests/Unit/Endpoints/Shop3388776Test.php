<?php

namespace Tests\Unit\Endpoints;

use App\Endpoints\NailLabo;
use App\Endpoints\Shop3388776;
use PHPUnit\Framework\TestCase;

class Shop3388776Test extends TestCase
{

    public function testAnalyze()
    {
        $analyzer = new Shop3388776();
        $html = file_get_contents(__DIR__ . '/../../html/shop3388776.html');

        $result = $analyzer->analyze($html);

        $this->assertTrue(is_array($result) && !empty($result));
    }
}
