<?php
namespace App\Traits\Responses;

use App\Jobs\SendTicketViaMail;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

trait MailTrait
{
    public function sendMail(array $data) {
        $path = 'app/public/qrcode/'.$data['submission_id'].'.svg';
        $fullpath = storage_path($path);
        $data['qrcode_url'] = env('APP_URL', 'gdsc-fu.com') . '/get-ticket/' . $data['submission_id'];
        QrCode::format("svg")->size(300)->generate($data['qrData'], $fullpath);
        SendTicketViaMail::dispatch($data);
    }
}
