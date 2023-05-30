<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

use Illuminate\Database\Eloquent\SoftDeletes;

class Users extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    // 변경 가능한 항목 
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    // $hidden => password와 remember_token을 제외한 데이터를 json으로 넘기겠다
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */

    // datetime으로 자동으로 변환해 주겠다.
    // 엘로퀀트로 사용했을 때 자동으로 변경해줌 
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    // 엘로퀀트를 이용하여 softDelete를 하여 자동으로 갱신할 때 사용해야함
    protected $dates = ['deleted_at'];
}
