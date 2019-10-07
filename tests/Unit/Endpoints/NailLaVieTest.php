<?php

namespace Tests\Unit\Endpoints;

use App\Endpoints\NailLaVie;
use PHPUnit\Framework\TestCase;

class NailLaVieTest extends TestCase
{

    public function testAnalyze()
    {
        $analyzer = new NailLaVie();
        $html = file_get_contents(__DIR__ . '/../../html/naillavie.html');

        $result = $analyzer->analyze($html);

        $this->assertTrue(is_array($result) && !empty($result));
    }
}
