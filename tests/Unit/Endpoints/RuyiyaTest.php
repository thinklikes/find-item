<?php

namespace Tests\Unit\Endpoints;

use App\Endpoints\Ruyiya;
use PHPUnit\Framework\TestCase;

class RuyiyaTest extends TestCase
{

    public function testAnalyze()
    {
        $analyzer = new Ruyiya();
        $html = file_get_contents(__DIR__ . '/../../html/ruyiya.html');

        $result = $analyzer->analyze($html);

        $this->assertTrue(is_array($result) && !empty($result));
    }
}
