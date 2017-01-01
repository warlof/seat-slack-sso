<?php
/**
 * User: Warlof Tutsimo <loic.leuilliot@gmail.com>
 * Date: 01/01/2017
 * Time: 01:07
 */

namespace Warlof\Seat\Slack\Sso\Http\Validations;


use Illuminate\Foundation\Http\FormRequest;

class ConfigurationValidation extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'slack-configuration-client' => 'required|string',
            'slack-configuration-secret' => 'required|string',
            'slack-sso-enabled' => 'required|boolean'
        ];
    }
}