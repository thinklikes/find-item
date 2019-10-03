<?php

namespace Tests\Unit\Endpoints;

use App\Endpoints\Ruyiya;
use PHPUnit\Framework\TestCase;

class RuyiyaTest extends TestCase
{

    public function testAnalyze()
    {
        $analyzer = new Ruyiya();
        $html = file_get_contents(__DIR__ . '/../../../storage/ruyiya.html');

        $result = $analyzer->analyze($html);

        $this->assertTrue(true);
    }
}
