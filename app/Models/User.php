<?php
namespace App\Models;
use App\Services\UploadFile;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
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
        'univ_id',
        'classe_id'
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
    /**
     * @var mixed
     */
    static $full_name;

    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }public function classe(): BelongsTo
    {
        return $this->belongsTo(Classe::class);
    }
    public function profile():HasOne
    {
        return $this->hasOne(Profile::class);
    }
    public function conversations()
    {
        return $this->hasMany(Conversation::class, 'started_by')
        ->orWhere('second_user', $this->id)
        ->with(['startedBy', 'secondUser','secondUser.profile', 'startedBy.profile','messages'=>function($query){
            $query->latest('created_at')->take(1);
        }])
        ->latest('updated_at');
    }

    public function basePosts(): HasMany
    {
        return $this->hasMany(BasePost::class);
    }

    public static function getUserInfo($id){
        return User::with(['profile','role'])->find($id);
    }
    public static function getProfileById($id){
        $relations = ['basePost','basePost.user:id,email','basePost.user.profile:user_id,full_name,profile_url'];



        $followersCount = Follower::where('following_id', $id)->count();

        $followingsCount = Follower::where('follower_id', $id)->count();

        $followers =[
            'followers_count' => $followersCount,
            'followings_count' => $followingsCount,
        ];

        $announcements = Announcement::whereHas('basePost',function ($q) use ($id) {
            $q->where('user_id',$id);
        })->with($relations)
            ->get()
            ->toArray();

        $posts = Post::whereHas('basePost',function ($q) use ($id) {
            $q->where('user_id',$id);
        })->with($relations)
            ->get()
            ->toArray();
        $merged = array_merge($announcements, $posts);
        usort($merged,function($a, $b) {
            return strcmp( $b['base_post']['created_at'],$a['base_post']['created_at']);
        });
        $user = User::select('id','email','classe_id')
            ->with([
                'profile:user_id,full_name,profile_url',
                'classe:id,name'
            ])
            ->where('id',$id)
            ->first();
        $user->posts = $merged;
        $user->followers = $followers;
        return $user;
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

            $user->profile()->create([
                'full_name' => User::$full_name
            ]);
        });
    }
}
