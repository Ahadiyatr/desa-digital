<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EventParticipantUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'event_id' => 'required|exists:events,id',
            'head_of_family_id' => 'required|string|max:255',
            'quantity' => 'nullable|integer',
            'paymnent_status' => 'nullable|string',
        ];
    }

    public function attributes()
    {
        return [
            'event_id' => 'Event',
            'head_of_family_id' => 'Kepala Keluarga',
            'quantity' => 'Jumlah',
            'payment_status' => 'Status Pembayaran',
        ];
    }
}
