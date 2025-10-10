<?php

namespace App\Http\Requests;

use App\Models\FamilyMember;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class FamilyMemberUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        // Tangkap route parameter
    $familyMemberId = $this->route('family-member');

    // Ambil user_id jika ada
    $userId = null;
    if ($familyMemberId) {
        $familyMember = FamilyMember::find($familyMemberId);
        $userId = $familyMember?->user_id; // pakai nullsafe operator biar aman
    }

    return [
        'name' => 'required|string|max:255',
        'email' => [
            'nullable',
            'string',
            'email',
            'max:255',
            Rule::unique('users', 'email')->ignore($userId),
        ],
        'password' => 'nullable|string|min:8',
        'profile_picture' => 'nullable|image|mimes:jpg|max:2048',
        'identity_number' => 'required|integer',
        'gender' => 'required|string|in:male,female',
        'date_of_birth' => 'required|date',
        'phone_number' => 'required|string',
        'occupation' => 'required|string',
        'marital_status' => 'required|string|in:married,single',
        'relation' => 'required|string|in:wife,child,husband'
    ];
    }

    public function attributes()
    {
        return [
            'name' => 'Nama',
            'email' => 'Email',
            'password' => 'Kata Sandi',
            'profile_picture' => 'Foto Profil',
            'identity_number' => 'Nomor Identitas',
            'gender' => 'Jenis Kelamin',
            'phone_number' => 'Nomor Telepon',
            'occupation' => 'Pekerjaan',
            'marital_status' => 'Status Pekerjaan',
            'relation' => 'Hubungan',
        ];
    }
}
