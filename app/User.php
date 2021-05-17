<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'social_auth'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getId()
    {
        return $this->id;
    }

    /**
     * Checks if a User already exists or creates a new one
     *
     * @param array $data               User data
     * @param string $socialProvider    Social media origin
     *
     * @return User
     */
    static function getOrCreate($data, $socialProvider)
    {
        $user = self::where([
            'social_auth->' . $socialProvider . '->id' => $data['social_id'],
        ])->first();

        if($user === null){
            $user = self::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'social_auth' => json_encode([
                    $socialProvider => [
                        'id'    => $data['social_id'],
                    ]
                ])
            ]);
        }

        return $user;
    }

}
