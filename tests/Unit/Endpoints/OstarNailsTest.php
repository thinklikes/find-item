<?php

namespace Tests\Unit\Endpoints;

use App\Endpoints\OstarNails;
use PHPUnit\Framework\TestCase;

class OstarNailsTest extends TestCase
{

    public function testAnalyze()
    {
        $analyzer = new OstarNails();
        $html = file_get_contents(__DIR__ . '/../../html/ostarnails.html');

        $result = $analyzer->analyze($html);

        $this->assertTrue(is_array($result) && !empty($result));
    }
}
