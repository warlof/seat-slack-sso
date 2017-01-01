<?php
/**
 * User: Warlof Tutsimo <loic.leuilliot@gmail.com>
 * Date: 29/12/2016
 * Time: 22:13
 */

namespace Warlof\Seat\Slack\Sso\Extensions;


use Illuminate\Http\Request;
use Laravel\Socialite\Two\AbstractProvider;
use Laravel\Socialite\Two\ProviderInterface;
use Laravel\Socialite\Two\User;

class SlackProvider extends AbstractProvider implements ProviderInterface
{

    protected $scopes = [
        'identity.basic',
        'identity.email',
        'identity.team'
    ];

    public function __construct(Request $request, $clientId, $clientSecret, $redirectUrl)
    {
        parent::__construct($request, $clientId, $clientSecret, $redirectUrl);

        $this->clientId = setting('warlof.slack.sso.credentials.client_id', true);
        $this->clientSecret = setting('warlof.slack.sso.credentials.client_secret', true);
        $this->redirectUrl = url()->to('/slacksso/auth/callback');
    }

    /**
     * Get the authentication URL for the provider.
     *
     * @param  string $state
     * @return string
     */
    protected function getAuthUrl($state)
    {
        return $this->buildAuthUrlFromBase(
            'https://slack.com/oauth/authorize', $state
        );
    }

    /**
     * Get the token URL for the provider.
     *
     * @return string
     */
    protected function getTokenUrl()
    {
        return 'https://slack.com/api/oauth.access';
    }

    /**
     * Get the raw user for the given access token.
     *
     * @param  string $token
     * @return array
     */
    protected function getUserByToken($token)
    {
        $response = $this->getHttpClient()
            ->get('https://slack.com/api/users.identity?token=' . $token);

        $data = json_decode($response->getBody()->getContents(), true);
        $data['access_token'] = $token;

        return $data;
    }

    /**
     * Map the raw user array to a Socialite User instance.
     *
     * @param  array $user
     * @return \Laravel\Socialite\Two\User
     */
    protected function mapUserToObject(array $user)
    {
        return (new User())->setRaw($user)->map([
            'name' => $user['user']['name'],
            'email' => $user['user']['email'],
            'user_id' => $user['user']['id'],
            'team_id' => $user['team']['id'],
            'access_token' => $user['access_token']
        ]);
    }
}