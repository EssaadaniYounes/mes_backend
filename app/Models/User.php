<?php
namespace App\Models;
use App\Services\UploadFile;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email',
        'password',
        'role_id',
        'univ_id'
    ];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
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

    public function role():BelongsTo
    {
        return $this->belongsTo(Role::class);
    }
    public function profile():HasOne
    {
        return $this->hasOne(Profile::class);
    }
    public static function getUserInfo($id){
        return User::with(['profile','role'])->find($id);
    }

    public static function uploadUsers(Request $request): string
    {
        return (
        new UploadFile('xlsxs/users','file')
        )->uploadSingle($request);

    }
    protected static function booted()
    {
        static::created(function (User $user){
            $user->profile()->create();
        });
    }
}
