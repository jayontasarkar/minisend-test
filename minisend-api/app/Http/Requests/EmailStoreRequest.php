<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EmailStoreRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'recipient'   => 'required|email',
            'sender'   => 'required|email',
            'html_content' => 'required',
            'text_content' => 'required',
            'subject'      => 'required'
        ];
    }
}
