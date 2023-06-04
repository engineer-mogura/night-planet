<?php
namespace App\Mailer;

use Cake\Mailer\Mailer;

class CastMailer extends Mailer
{
    public function castRegistration($cast)
    {
        $this
            ->to($cast->email)
            ->setSubject('ご登録ありがとうございます。')
            ->set('cast', $cast);
    }
}
