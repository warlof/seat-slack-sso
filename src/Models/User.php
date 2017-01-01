<?php
/**
 * User: Warlof Tutsimo <loic.leuilliot@gmail.com>
 * Date: 29/12/2016
 * Time: 21:23
 */

namespace Warlof\Seat\Slack\Sso\Models;


use Seat\Web\Models\User as SeatUser;

class User extends SeatUser
{
    protected $fillable = [
        'slack_sso_uid', 'slack_sso_tid', 'slack_sso_access_token', 'name', 'email', 'active', 'password'
    ];
}