<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InstallRequest extends FormRequest
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
            'site_url' => 'required|url',
            'site_title' => 'required|max:255',
            'db_host' => 'required',
            'db_name' => 'required',
            'db_username' => 'required',
            'admin_email' => 'required|email',
            'admin_password' => 'required|min:6',
        ];
    }
}
