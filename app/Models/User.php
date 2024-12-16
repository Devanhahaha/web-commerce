<?php

namespace App\Models;


use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;


     // Tambahkan method ini
     public function getJWTIdentifier()
     {
         return $this->getKey();
     }
 
     public function getJWTCustomClaims()
     {
         return [];
     }

    use Notifiable;

    // Your existing code...

    /**
     * Check if the user is an admin.
     *
     * @return bool
     */
    public function isAdmin()
    {
        // Assuming you have a role field or a similar way to determine if a user is an admin.
        // Adjust the condition according to your application's logic.
        return $this->role === 'admin';
    }
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    //cara 1 untuk mendefinisikan kolom mana aja yang bisa diisi
    // protected $fillable = [
    //     'name',
    //     'email',
    //     'password',
    // ];

    // cara 2 untuk mendefinisikan kolom mana aja yang tidak bisa diisi
        protected $guarded = [];
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
}