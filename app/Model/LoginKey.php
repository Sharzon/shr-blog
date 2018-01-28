<?php

namespace App\Model;

use App\DB;
/**
* 
*/
class LoginKey extends Model
{
    static protected $table = 'login_keys';
    static protected $id_field = 'key_string';
    static protected $fields = [
        'key_string',
        'expires_at'
    ];
    static protected $timestamps = false;

    public static function createKey()
    {
        $key = new LoginKey;

        $key_string = uniqid(mt_rand(), true);
        $key['key_string'] = $key_string;
        $datetime = new \DateTime;
        $datetime->modify('+1 day');
        $key['expires_at'] = $datetime->format('Y-m-d H:i:s');

        $key->save();

        return $key['key_string'];
    }

    public static function isKeyValid($key)
    {
        $pdo = DB::getPDO();

        $query = "SELECT * FROM login_keys WHERE key_string = :key AND expires_at > NOW()";

        $stmt = $pdo->prepare($query);
        $stmt->execute(['key' => $_COOKIE['key']]);

        return count($keys) > 0;
    }
}