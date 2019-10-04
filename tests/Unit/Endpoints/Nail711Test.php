<?php

namespace Tests\Unit\Endpoints;

use App\Endpoints\Nail711;
use PHPUnit\Framework\TestCase;

class Nail711Test extends TestCase
{

    public function testAnalyze()
    {
        $analyzer = new Nail711();
        $html = file_get_contents(__DIR__ . '/../../../storage/nail711.html');

        $result = $analyzer->analyze($html);

        $this->assertTrue(is_array($result) && !empty($result));
    }
}
