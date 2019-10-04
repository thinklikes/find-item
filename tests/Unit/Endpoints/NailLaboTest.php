<?php

namespace Tests\Unit\Endpoints;

use App\Endpoints\NailLabo;
use PHPUnit\Framework\TestCase;

class RuyiyaTest extends TestCase
{

    public function testAnalyze()
    {
        $analyzer = new NailLabo();
        $html = file_get_contents(__DIR__ . '/../../../storage/naillabo.html');

        $result = $analyzer->analyze($html);

        $this->assertTrue(is_array($result) && !empty($result));
    }
}
