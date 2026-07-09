<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;

    protected $table = 'users';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'leve',
        'name',
        'email',
        'password',
        'email_verified_at',
        'remember_token'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public static function incrementId()
    {
        $date = date('ymd');
        $lastId = Self::withTrashed()->orderBy('id', 'desc')->first();
        if ($lastId) {
            $lastId = $lastId->id;
            $lastId = preg_replace('/U-/', '', $lastId);
            if (preg_match('/^' . $date . '/', $lastId)) {
                $val = (int)preg_replace('/^' . $date . '/', '', $lastId) + 1;
                $val =  str_pad($val, 3, "0", STR_PAD_LEFT);
                return 'U-' . $date . $val;
            } else {
                return 'U-' . $date . '001';
            }
        } else {
            return 'U-' . $date . '001';
        }
    }

    public function userLevel()
    {
        return $this->hasOne(UserLevel::class, 'id', 'level');
    }

    public function transaksi()
    {
        return $this->hasMany(Transaksi::class, 'kasir_id', 'id');
    }

    public function detailTransaksi()
    {
        return $this->hasManyThrough(DetailTransaksi::class, Transaksi::class, 'kasir_id', 'transaksi_id', 'id', 'no_resi');
    }
}
