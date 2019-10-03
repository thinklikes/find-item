<?php

namespace Tests\Unit\Endpoints;

use App\Endpoints\NailsInJapan;
use PHPUnit\Framework\TestCase;

class NailsInJapanTest extends TestCase
{

    public function testAnalyze()
    {
        $analyzer = new NailsInJapan();
        $html = file_get_contents(__DIR__ . '/../../../storage/nailsinjapan.html');

        $analyzer->analyze($html);

        $this->assertTrue(true);
    }
}
