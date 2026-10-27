<?php

namespace App\Tests;

use PHPUnit\Framework\TestCase;
use App\DemoService;

class DemoServiceTest extends TestCase
{
    private DemoService $service;

    protected function setUp(): void
    {
        $this->service = new DemoService();
    }

    public function testGetStatusReturnsCorrectMessage(): void
    {
        $this->assertSame("Composer environment is fully operational!", $this->service->getStatus());
    }

    public function testGenerateSamplePdfReturnsValidPdf(): void
    {
        $pdf = $this->service->generateSamplePdf("Тест", "Проверка содержимого");
        $this->assertNotEmpty($pdf);
        $this->assertStringStartsWith("%PDF", $pdf);
    }

    public function testSpreadsheetCreation(): void
    {
        $spreadsheet = $this->service->createSampleSpreadsheet();
        $this->assertSame("Курс по Composer", $spreadsheet->getActiveSheet()->getCell('B2')->getValue());
    }

    public function testDatabaseOrmInitialization(): void
    {
        $result = $this->service->testDatabaseOrm();
        $this->assertStringContainsString("Illuminate\\Database\\Capsule\\Manager", $result);
    }

    public function testSmsVerificationText(): void
    {
        $result = $this->service->testSmsVerification();
        $this->assertStringContainsString("+79991234567", $result);
        $this->assertStringContainsString("7482", $result);
    }
}
