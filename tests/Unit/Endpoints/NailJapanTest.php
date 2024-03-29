<?php

namespace Tests\Unit\Endpoints;

use App\Endpoints\NailJapan;
use PHPUnit\Framework\TestCase;

class NailJapanTest extends TestCase
{

    public function testAnalyze()
    {
        $analyzer = new NailJapan();
        $html = file_get_contents(__DIR__ . '/../../html/nailjapan.html');

        $result = $analyzer->analyze($html);

        $this->assertTrue(is_array($result) && !empty($result));
    }
}
