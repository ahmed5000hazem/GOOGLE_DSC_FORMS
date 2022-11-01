<?php
namespace App\Traits\Responses;

use App\Jobs\SendTicketViaMail;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

trait MailTrait
{
    public function sendMail(array $data) {
        $path = 'app/public/qrcode/'.$data['qrData'].'.svg';
        $fullpath = storage_path($path);
        $data['qrcode_url'] = env('APP_URL').'/get-ticket/'.$data['qrData'];
        QrCode::format("svg")->size(300)->generate($data['qrData'], $fullpath);
        SendTicketViaMail::dispatch($data);
    }
}
