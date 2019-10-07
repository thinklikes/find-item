<?php

namespace Tests\Unit\Endpoints;

use App\Endpoints\OnsNail;
use PHPUnit\Framework\TestCase;

class OnsNailTest extends TestCase
{

    public function testAnalyze()
    {
        $analyzer = new OnsNail();
        $html = file_get_contents(__DIR__ . '/../../html/onsnail.html');

        $result = $analyzer->analyze($html);

        $this->assertTrue(is_array($result) && !empty($result));
    }
}
