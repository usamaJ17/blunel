<?php

namespace App\Services;

class EmergencyContactService
{
    /**
     * @return array[user_id: int|string, name: mixed, phone: mixed]
     */
    public function getEmergencyContactData(object $request , string|int $id):array
    {
        return [
            'user_id' => $id,
            'name' => $request['name'],
            'phone' => $request['phone'],
        ];
    }
}
