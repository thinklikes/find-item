<?php

namespace Tests\Unit\Endpoints;

use App\Endpoints\NailsInJapan;
use PHPUnit\Framework\TestCase;

class NailsInJapanTest extends TestCase
{

    public function testAnalyze()
    {
        $analyzer = new NailsInJapan();
        $html = file_get_contents(__DIR__ . '/../../html/nailsinjapan.html');

        $result = $analyzer->analyze($html);

        $this->assertTrue(is_array($result) && !empty($result));
    }
}
