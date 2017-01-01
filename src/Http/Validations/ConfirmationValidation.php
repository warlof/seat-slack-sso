<?php
/**
 * User: Warlof Tutsimo <loic.leuilliot@gmail.com>
 * Date: 01/01/2017
 * Time: 01:05
 */

namespace Warlof\Seat\Slack\Sso\Http\Validations;


use Illuminate\Foundation\Http\FormRequest;

class ConfirmationValidation extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'email' => 'required|email',
            'name' => 'required|string',
            'password' => 'required|string'
        ];
    }
}