<?php

namespace App\Services;

use App\Enums\RoleEnum;
use MailchimpMarketing\ApiClient;
use Illuminate\Support\Facades\Log;

class NewsletterService
{
    public function subscribe(string $name, string $email, $list = null)
    {
        $list ??= config('services.mailchimp.lists.subscribers');

        return $this->client()->lists->addListMember($list, [
            'email_address' => $email,
            'tags' => array(RoleEnum::delegator()->value),
            'status' => 'subscribed',
            'merge_fields'  => array(
                'NAME' => $name,
              )
        ]);
    }

    protected function client()
    {
        return (new ApiClient())->setConfig([
            'apiKey' => config('services.mailchimp.key'),
            'server' => config('services.mailchimp.server'),
        ]);
    }
}