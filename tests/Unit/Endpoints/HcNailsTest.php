<?php

namespace Tests\Unit\Endpoints;

use App\Endpoints\HcNails;
use PHPUnit\Framework\TestCase;

class RuyiyaTest extends TestCase
{

    public function testAnalyze()
    {
        $analyzer = new HcNails();
        $html = file_get_contents(__DIR__ . '/../../../storage/hcnails.html');

        $result = $analyzer->analyze($html);

        $this->assertTrue(is_array($result) && !empty($result));
    }
}
