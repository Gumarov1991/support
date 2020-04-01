<?php

namespace App\Http\Requests\Tickets;

use Illuminate\Foundation\Http\FormRequest;

class CreateRequest extends FormRequest
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
        $rules = [
            'subject'   => 'required|min:10|max:100',
            'content'   => 'required|min:10|max:1000'
        ];

        $photos = count($this->input('photos'));

        foreach (range(0, $photos) as $index) {
            $rule['photos.' . $index] = 'image|mimes:jpg,jpeg,bmp,png|max:2000';
        }

        return $rules;
    }
}
