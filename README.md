# seat-slack-sso
A Eve SeAT plugin which enable Slack SSO

# Setup
## Slack side
1. go on [Slack Application](https://api.slack.com/apps)
2. clic on `Create New App`
3. on left side, clic on `OAuth & Permissions`, put `https://domain/slacksso/auth/callback` and save changes

## SeAT side
### Server
1. go into your SeAT installation path
2. run `composer require warlof/seat-slack-sso` as the SeAT user
3. open the file into `seatpath/config/app.php` with your favorite editor
4. add `Warlof\Seat\Slack\Sso\SlackSsoServiceProvider::class` after `* Package Service Providers...` block
5. publish vendor by running `php artisan vendor:publish --force` as the SeAT user
6. run migration scripts with `php artisan migrate` as the SeAT user

### Client
1. sign in with a superuser account
2. in sidebar, go on `Slack SSO Authentication > Settings`
3. fill the form using credentials created with the Slack Application (available into `Basic Information`)
4. hit `Update` and enjoy the new SSO authentication :)

# Extra
If you like the package, please consider making a donation to [eveseat.net holding](https://gate.eveonline.com/Corporation/eveseat.net).
Funds are cross shared for R&D and SeAT core development.

See us on official SeAT slack <a href="https://eveseat-slack.herokuapp.com/"><img src="https://eveseat-slack.herokuapp.com/badge.svg" /></a>