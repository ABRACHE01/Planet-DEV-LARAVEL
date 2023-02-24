<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Mail\Mailables\Content;

class StoreCommentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            
            "content"=>"required|string|min:3|max:255",
            "user_id"=>"required|integer|exists:users,id",
            "article_id"=>"required|integer|exists:articles,id",

        ];
    }
}
