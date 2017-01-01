<?php
/**
 * User: Warlof Tutsimo <loic.leuilliot@gmail.com>
 * Date: 29/12/2016
 * Time: 20:56
 */

namespace Warlof\Seat\Slack\Sso\Http\Controllers;


use Illuminate\Routing\Controller;
use Laravel\Socialite\Contracts\Factory;
use Laravel\Socialite\Two\User as SocialiteUser;
use Warlof\Seat\Slack\Sso\Http\Validations\ConfigurationValidation;
use Warlof\Seat\Slack\Sso\Http\Validations\ConfirmationValidation;
use Warlof\Seat\Slack\Sso\Models\User;

class SlackSsoController extends Controller
{

    public function redirectToProvider(Factory $social)
    {
        if (setting('warlof.slack.sso.allowed', true) != '1') {
            abort(403);
        }

        return $social->driver('slack')->redirect();
    }

    public function handleProviderCallback(Factory $social)
    {
        $slack_data = $social->driver('slack')->user();

        // Check if there is a SeAT account with the same name or email address. If this is the case,
        // We need to confirm that the current user is the account owner before we convert the account to an
        // SSO account.
        if (User::where('slack_sso_uid', null)
            ->where(function($q) use ($slack_data) {
                $q->where('name', $slack_data->name)
                    ->orWhere('email', $slack_data->email);
            })->first()) {

            // Store the data from Slack into the session
            session()->put('warlof.slack.sso', $slack_data);

            // Redirect to the password confirmation page.
            return redirect()->route('warlof.slack.sso.auth.confirmation');
        }

        // Get or create the User bound to this login.
        $user = $this->findOrCreateUser($slack_data);

        // Login the account
        auth()->login($user, true);

        return redirect()->intended();
    }

    public function getSsoConfirmation()
    {
        if (auth()->check()) {
            return redirect()->home();
        }

        return view('slacksso::auth.confirmation');
    }

    public function postSsoConfirmation(ConfirmationValidation $request)
    {
        if (auth()->check()) {
            return redirect()->home();
        }

        $user = User::where('name', session()->get('warlof.slack.sso')->name)
            ->orWhere('email', session()->get('warlof.slack.sso')->email)
            ->first();

        if (auth()->attempt([
            'name' => $user->name,
            'password' => $request->input('password')
        ])) {

            // Change SeAT account to an SSO account
            $user->update([
                'slack_sso_uid' => session()->get('warlof.slack.sso')->user_id,
                'slack_sso_tid' => session()->get('warlof.slack.sso')->team_id,
                'slack_sso_access_token' => session()->get('warlof.slack.sso')->access_token
            ]);

            // Authenticate the user.
            if (auth()->check() == false)
                auth()->login($user, true);

            // Remove the SSO data from the session
            session()->forget('warlof.slack.sso');

            return redirect()->intended();
        }

        session()->forget('warlof.slack.sso');

        return redirect()->home();
    }

    public function getConfiguration()
    {
        return view('slacksso::configuration');
    }

    public function postConfiguration(ConfigurationValidation $request)
    {
        setting(['warlof.slack.sso.credentials.client_id',  $request->input('slack-configuration-client')], true);
        setting(['warlof.slack.sso.credentials.client_secret', $request->input('slack-configuration-secret')], true);
        setting(['warlof.slack.sso.allowed', $request->input('slack-sso-enabled')], true);

        return redirect()->back()
            ->with('success', trans('change-applied'));
    }

    private function findOrCreateUser(SocialiteUser $user) : User
    {
        if ($existing = User::where('slack_sso_uid', $user->user_id)
            ->where('slack_sso_tid', $user->team_id)
            ->where('slack_sso_access_token', $user->access_token)
            ->first())
            return $existing;

        if ($existing = User::where('slack_sso_uid', $user->user_id)
            ->where('slack_sso_tid', $user->team_id)
            ->first()) {
            $existing->update([
                'name' => $user->name,
                'email' => $user->email,
                'slack_sso_access_token', $user->access_token
            ]);

            return $existing;
        }

        return User::create([
            'name' => $user->name,
            'email' => $user->email,
            'active' => 1, // We enable the account since we get the mail address from Slack
            'password' => bcrypt(str_random(128)), // Random Password
            // Slack SSO credentials
            'slack_sso_uid' => $user->user_id,
            'slack_sso_tid' => $user->team_id,
            'slack_sso_access_token' => $user->access_token,
        ]);
    }

}