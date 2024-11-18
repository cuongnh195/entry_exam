<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateHotelRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'hotel_name' => 'nullable|string|max:255',
            'prefecture_id' => 'nullable|exists:prefectures,prefecture_id',
            'file' => 'nullable|file|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'file.mimes' => __('validation.mimes', ['attribute' => '画像']),
            'file.max' => __('validation.max', ['attribute' => '画像', 'max' => '2MB']),
            'hotel_name.max' => __('validation.max', ['attribute' => 'ホテル名', 'max' => '255文字']),
            'prefecture_id.exists' => __('validation.exists', ['attribute' => '都道府県']),
        ];
    }
}
