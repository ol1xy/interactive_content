<?php

namespace App;

use Dompdf\Dompdf;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use Illuminate\Database\Capsule\Manager as CapsuleManager;
use Predis\Client as RedisClient;
use Zelenin\SmsRu\Auth\ApiIdAuth;
use Zelenin\SmsRu\Api as SmsRuApi;
use Zelenin\SmsRu\Entity\Sms;
use Symfony\Component\Mime\Email;
use Aws\S3\S3Client;
use League\OAuth2\Client\Provider\GenericProvider;

class DemoService
{
    public function getStatus(): string
    {
        return "Composer environment is fully operational!";
    }


    public function testDatabaseOrm(): string
    {
        $capsule = new CapsuleManager();
        $capsule->addConnection([
            'driver' => 'sqlite',
            'database' => ':memory:',
        ]);
        return get_class($capsule) . " успешно инициализирован (драйвер SQLite в памяти)";
    }


    public function testRedisCache(): string
    {
        $redis = new RedisClient([
            'scheme' => 'tcp',
            'host'   => '127.0.0.1',
            'port'   => 6379,
        ]);
        return get_class($redis) . " успешно сконфигурирован для подключения к Redis";
    }

  
    public function createSampleSpreadsheet(): Spreadsheet
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'ID');
        $sheet->setCellValue('B1', 'Название');
        $sheet->setCellValue('C1', 'Цена');

        $sheet->setCellValue('A2', 1);
        $sheet->setCellValue('B2', 'Курс по Composer');
        $sheet->setCellValue('C2', 5000);

        return $spreadsheet;
    }


    public function generateSamplePdf(string $title, string $content): string
    {
        $dompdf = new Dompdf();
        $html = "<html><body><h1>{$title}</h1><p>{$content}</p></body></html>";
        $dompdf->loadHtml($html);
        $dompdf->render();
        return $dompdf->output();
    }


    public function testSmsVerification(): string
    {
        $auth = new ApiIdAuth('demo-api-key');
        $client = new \Zelenin\SmsRu\Client\Client();
        $api = new SmsRuApi($auth, $client);
        $sms = new Sms('+79991234567', 'Ваш проверочный код: 7482');
        return "Классы " . get_class($api) . " и " . get_class($sms) . " сформировали сообщение: '{$sms->text}' для {$sms->to}";
    }


    public function testEmailMessage(): string
    {
        $email = (new Email())
            ->from('noreply@myshop.ru')
            ->to('client@example.com')
            ->subject('Подтверждение заказа №1042')
            ->text('Спасибо за заказ! Мы уже начали его сборку.');

        return get_class($email) . " создал письмо с темой: '{$email->getSubject()}'";
    }


    public function testAwsS3Client(): string
    {
        $s3 = new S3Client([
            'version' => 'latest',
            'region'  => 'eu-central-1',
            'credentials' => [
                'key'    => 'MOCK_KEY',
                'secret' => 'MOCK_SECRET',
            ],
        ]);
        return get_class($s3) . " создан для региона: " . $s3->getRegion();
    }

    public function testOAuth2Provider(): string
    {
        $provider = new GenericProvider([
            'clientId'                => 'demo-app-id',
            'clientSecret'            => 'demo-app-secret',
            'redirectUri'             => 'https://example.com/callback',
            'urlAuthorize'            => 'https://oauth.provider.com/authorize',
            'urlAccessToken'          => 'https://oauth.provider.com/token',
            'urlResourceOwnerDetails' => 'https://oauth.provider.com/user'
        ]);
        return get_class($provider) . " успешно сконфигурирован для OAuth2 потока";
    }
}
