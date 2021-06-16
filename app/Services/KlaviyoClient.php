<?php

namespace App\Services;

use Klaviyo\Klaviyo;
use Klaviyo\Model\EventModel as KlaviyoEvent;
use Klaviyo\Model\ProfileModel as KlaviyoProfile;


class KlaviyoClient
{
    private $contactsListId;

    public $client;


    public function __construct()
    {
        $this->client = new Klaviyo(env('KLAVIYO_PRIVATE_API_KEY'), env('KLAVIYO_PUBLIC_API_KEY'));
        $this->contactsListId = env('KLAVIYO_CONTACTS_LIST_ID');
    }

    public function trackEvent($email)
    {
        $now = new \DateTime();

        $event = new KlaviyoEvent([
            'event'               => 'Submit form',
            'customer_properties' => [
                '$email' => $email,
            ],
            'properties' => [
                'date' => $now->format('d.m.Y H:i:s')
            ],
        ]);

        $this->client->publicAPI->track($event);
    }

    public function addContact(array $data)
    {
        $profile = new KlaviyoProfile([
            'first_name'    => $data['name'],
            '$email'        => $data['email'],
            '$phone_number' => $data['phone'],
        ]);

        $this->client->lists->addMembersToList($this->contactsListId, [$profile]);
    }

    public function updateContact(array $data, string $oldEmail)
    {
        $id = $this->client->profiles->getProfileIdByEmail($oldEmail);
        if (!empty($id)) {
            $properties = [
                'first_name'    => $data['name'],
                '$email'        => $data['email'],
                '$phone_number' => $data['phone'],
            ];
            $this->client->profiles->updateProfile($id['id'], $properties);
        }
    }
}
