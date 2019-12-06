<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;

class RegistRequest extends FormRequest
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
            //
            'name' => 'required|string|min:2|max:18',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6'
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     * 
     * @return array
     */
    public function messages()
    {
        return [
            'name.required' => '请输入用户名',
            'name.string' => '用户名包含非法字符',
            'name.min' => '用户名必须为2~18位字符',
            'name.max' => '用户名必须为2~18位字符',
            'email.required' => '请输入邮箱地址',
            'email.email' => '请输入合法的邮箱地址',
            'email.unique' => '该邮箱已注册！',
            'password.required' => '请输入密码',
            'password.min' => '请输入至少6位字符密码',
        ];
    }
}
