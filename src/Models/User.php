<?php
/**
 * User: Warlof Tutsimo <loic.leuilliot@gmail.com>
 * Date: 29/12/2016
 * Time: 21:23
 */

namespace Warlof\Seat\Slack\Sso\Models;


use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Seat\Web\Models\User as SeatUser;

class User extends SeatUser
{
    protected $fillable = [
        'slack_sso_uid', 'slack_sso_tid', 'slack_sso_access_token', 'name', 'email', 'active', 'password'
    ];

    public static function create(array $attributes = [])
    {
        $model = parent::create($attributes);

        if (Schema::hasTable('slack_users')) {
            DB::table('slack_users')->insert([
                'user_id' => $model->id,
                'slack_id' => $model->slack_sso_uid
            ]);
        }

        return $model;
    }

    public function update(array $attributes = [], array $options = [])
    {
        if (!parent::update($attributes, $options)) {
            return false;
        }

        if (Schema::hasTable('slack_users')) {

            $model = self::where('slack_sso_uid', $attributes['slack_sso_uid'])
                ->where('slack_sso_tid', $attributes['slack_sso_tid'])
                ->where('slack_sso_access_token', $attributes['slack_sso_access_token'])
                ->first();

            if (($user = DB::table('slack_users')->where('user_id', $model->id))->count()) {
                $user->update([
                    'slack_id' => $attributes['slack_sso_uid'],
                    'updated_at' => new Carbon()
                ]);
            } else {
                DB::table('slack_users')->insert([
                    'user_id' => $model->id,
                    'slack_id' => $attributes['slack_sso_uid'],
                    'created_at' => new Carbon(),
                    'updated_at' => new Carbon()
                ]);

            }
        }

        return true;
    }
}