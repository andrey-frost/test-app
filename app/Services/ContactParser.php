<?php

namespace App\Services;

use App\Models\Contact;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ContactParser
{
    public function parse($filePath)
    {
        if (($handle = fopen($filePath, 'r')) !== FALSE) {
            $rules = [
                'required|min:2',
                'required|email',
                'required|numeric',
            ];

            while (($data = fgetcsv($handle, 1000, ',')) !== FALSE) {
                $validator = Validator::make($data, $rules);
                if ($validator->fails()) {
                    continue;
                }

                $contact = new Contact();
                $contact->first_name = $data[0];
                $contact->email = $data[1];
                $contact->phone = $data[2];
                $contact->user_id = Auth::id();

                $contact->save();
            }
            fclose($handle);
        }
    }
}
