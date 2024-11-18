<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class CreateHotelRequest extends FormRequest
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
            'hotel_name' => 'required|string|max:255',
            'prefecture_id' => 'required|exists:prefectures,prefecture_id',
            'file' => 'required|file|mimes:jpeg,png,jpg,gif,svg|max:2048',
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
            'file.required' => __('validation.required', ['attribute' => '画像']),
            'file.mimes' => __('validation.mimes', ['attribute' => '画像']),
            'file.max' => __('validation.max', ['attribute' => '画像', 'max' => '2MB']),
            'hotel_name.required' => __('validation.required', ['attribute' => 'ホテル名']),
            'hotel_name.max' => __('validation.max', ['attribute' => 'ホテル名', 'max' => '255文字']),
            'prefecture_id.required' => __('validation.required', ['attribute' => '都道府県']),
            'prefecture_id.exists' => __('validation.exists', ['attribute' => '都道府県']),
        ];
    }
}
