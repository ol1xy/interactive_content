<?php

namespace App\Tests;

use PHPUnit\Framework\TestCase;
use App\DemoService;

class DemoServiceTest extends TestCase
{
    public function testGetStatusReturnsCorrectMessage(): void
    {
        $service = new DemoService();
        $this->assertSame("Composer environment is fully operational!", $service->getStatus());
    }

    public function testGenerateSamplePdfReturnsValidPdf(): void
    {
        $service = new DemoService();
        $pdf = $service->generateSamplePdf("Тест", "Проверка содержимого");
        
        $this->assertNotEmpty($pdf);
        $this->assertStringStartsWith("%PDF", $pdf);
    }
}
