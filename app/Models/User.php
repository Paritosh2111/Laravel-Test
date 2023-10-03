<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Education;
use App\Models\Company;
use App\Models\Hobby;


class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password','message',
        'phone', 'gender', 'education', 'message', 'image_path', 'education_id', 'company_id'
    ];

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
    ];

    /**
     * Define one to one Relationship.
     *
     * @var array<string, string>
     */

    public function education()
    {
        return $this->belongsTo(Education::class,'education_id');
    }

    // public function company()
    // {
    //     return $this->hasOne(Company::class);
    // }
    public function company()
{
    return $this->belongsTo(Company::class, 'company_id');
}

    public function hobbies()
    {
        return $this->belongsToMany(Hobby::class);
    }

    public function experiences()
    {
        return $this->hasMany(Experience::class);
    }
}
