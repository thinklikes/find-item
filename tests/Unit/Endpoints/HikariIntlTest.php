<?php

namespace Tests\Unit\Endpoints;

use App\Endpoints\HikariIntl;
use PHPUnit\Framework\TestCase;

class HikariIntlTest extends TestCase
{

    public function testAnalyze()
    {
        $analyzer = new HikariIntl();
        $html = file_get_contents(__DIR__ . '/../../html/hikariintl.html');

        $result = $analyzer->analyze($html);

        $this->assertTrue(is_array($result) && !empty($result));
    }
}
