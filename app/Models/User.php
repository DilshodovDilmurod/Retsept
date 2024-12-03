<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
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
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function recipes()
    {
        return $this->hasMany(Recipe::class);
    }
    public function sharedRecipes()
    {
        return $this->hasMany(Recipe::class); // or whatever type of relationship it should be
    }

    public function share(Request $request, Recipe $recipe)
    {
        // Emailni olish
        $email = $request->input('email');

        // Foydalanuvchini topish
        $user = User::where('email', $email)->first(); // User modelidan foydalanish

        if ($user) {
            // Foydalanuvchiga retseptni yuborish
            Mail::to($email)->send(new RecipeShared($recipe));

            // Retseptni baham ko‘rgan deb belgilash (agar kerak bo‘lsa)
            $recipe->is_shared = true;
            $recipe->save();

            return redirect()->back()->with('success', 'Recipe shared successfully!');
        } else {
            return redirect()->back()->with('error', 'User with this email not found!');
        }
    }
}
