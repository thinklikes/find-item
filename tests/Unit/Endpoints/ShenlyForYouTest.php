<?php

namespace Tests\Unit\Endpoints;

use App\Endpoints\NailLabo;
use App\Endpoints\ShenlyForYou;
use App\Endpoints\Shop3388776;
use PHPUnit\Framework\TestCase;

class ShenlyForYouTest extends TestCase
{

    public function testAnalyze()
    {
        $analyzer = new ShenlyForYou();
        $html = file_get_contents(__DIR__ . '/../../../storage/shenlyforyou.html');

        $result = $analyzer->analyze($html);

        $this->assertTrue(is_array($result) && !empty($result));
    }
}
