<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Enums\IdeaStatus;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class IdeaRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'min:5', 'max:255'],
            'description' => ['nullable', 'string', 'min:10'],
            'status' => ['required', 'string', Rule::enum(IdeaStatus::class)],
            'links' => ['nullable', 'array'],
            'links.*' => ['max:255', 'url'],
            'steps' => ['nullable', 'array'],
            'steps.*.description' => ['string', 'max:255', 'min:5'],
            'steps.*.completed' => ['boolean'],
            'image' => ['nullable', 'image', 'max:5120', 'mimes:jpg,png,jpeg,webp'],
        ];
    }
}
