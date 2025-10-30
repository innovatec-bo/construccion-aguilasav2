<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use RichanFongdasen\EloquentBlameable\BlameableTrait;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class User extends Authenticatable implements HasMedia
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;
    use HasRoles;
    use SoftDeletes;
    use BlameableTrait;
    use InteractsWithMedia;

    protected $table = "sec_users";
    protected $primaryKey = "id_usr";

    const CREATED_AT = 'createdon_usr';
    const UPDATED_AT = 'editedon_usr';
    const UPDATED_BY = 'editedby_usr';

    protected $guarded = [
        'createdon_usr',
        'editedon_usr',
        'created_at',
        'updated_at',
        'created_by',
        'updated_by',
        'deleted_by'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
        'firstname_usr',
        'lastname_usr',
        'email_usr',
        'facebookid_usr',
        'phone_usr',
        'password_usr',
        'avatar_usr',
        'passwordhash_usr',
        'activationhash_usr',
        'status_usr',
        'tax_deductible_usr',
        'googleid_usr',
        ''
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'profile_photo_url',
    ];

    public function getFullNameAttribute() 
    {
        return ucfirst(strtolower($this->firstname_usr)) . ' ' . ucfirst(strtolower($this->lastname_usr));
    }

    public function statusResponsible()
    {
        return $this->hasMany(StatusResponsible::class, 'user_id_sre');
    }

    public function getAuthPassword()
    {
        return $this->password_usr;
    }

    public function registerMediaCollections(): void
    {
        $this
            ->addMediaCollection('default')
            ->useFallbackUrl(asset('/admin-theme/img/avatars/default-avatar.jpg'))
            ->useFallbackPath(public_path('/admin-theme/img/avatars/default-avatar.jpg'))
            ->singleFile();
    }

    public function registerMediaConversions(?Media $media = null): void
    {
        $this->addMediaConversion('md')
              ->width(480)
              ->height(360)
              ->sharpen(10)->nonQueued();

        $this->addMediaConversion('sm')
              ->width(240)
              ->height(180)
              ->sharpen(10)->nonQueued();
    }
}
