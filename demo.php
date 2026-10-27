<?php

require_once __DIR__ . '/vendor/autoload.php';

use App\DemoService;


$service = new DemoService();

echo "[0] Автозагрузка PSR-4 нашего класса:\n";
echo "    -> " . $service->getStatus() . "\n\n";

echo "[1] База данных / ORM - illuminate/database:\n";
echo "    -> " . $service->testDatabaseOrm() . "\n\n";

echo "[2] In-Memory кэш - predis/predis:\n";
echo "    -> " . $service->testRedisCache() . "\n\n";

echo "[3] XLS-отчеты - phpoffice/phpspreadsheet:\n";
$spreadsheet = $service->createSampleSpreadsheet();
$sheet = $spreadsheet->getActiveSheet();
echo "    -> Успешно! Создан лист таблицы, ячейка B2: '" . $sheet->getCell('B2')->getValue() . "'\n\n";

echo "[4] PDF-документы - dompdf/dompdf:\n";
$pdfData = $service->generateSamplePdf(
    "Отчет интернет-магазина",
    "Документ успешно сгенерирован библиотекой dompdf/dompdf!"
);
file_put_contents(__DIR__ . '/sample.pdf', $pdfData);
echo "    -> Успешно! Сгенерирован файл sample.pdf (" . strlen($pdfData) . " байт)\n\n";

echo "[5] SMS-сообщения - zelenin/smsru:\n";
echo "    -> " . $service->testSmsVerification() . "\n\n";

echo "[6] E-mail уведомления - symfony/mailer:\n";
echo "    -> " . $service->testEmailMessage() . "\n\n";

echo "[7] Хранилище AWS S3 - aws/aws-sdk-php:\n";
echo "    -> " . $service->testAwsS3Client() . "\n\n";

echo "[8] Авторизация соцсетей - league/oauth2-client:\n";
echo "    -> " . $service->testOAuth2Provider() . "\n\n";

echo "[9] Средства тестирования в require-dev - phpunit/phpunit:\n";
echo "    -> Запускается отдельной CLI-командой: vendor/bin/phpunit tests\n\n";
