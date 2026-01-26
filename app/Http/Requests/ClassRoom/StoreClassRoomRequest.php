<?php

namespace App\Http\Requests\ClassRoom;

use Illuminate\Foundation\Http\FormRequest;

class StoreClassRoomRequest extends FormRequest
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
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:classes',
            'description' => 'nullable|string',
            'teacher_id' => 'required|exists:users,id',
            'academic_year' => 'required|string|max:20',
            'semester' => 'required|integer|min:1|max:2',
            'active' => 'boolean',
        ];
    }
}
