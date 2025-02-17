<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Enums\AssociationRole;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Gate;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasUuids;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'wca_id',
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

    protected function gate(): void
    {
        Gate::define('viewTelescope', function (User $user) {
            return in_array($user->email, [
                'oscarrothandersen@gmail.com',
            ]);
        });
    }

    public function contact(): BelongsTo
    {
        return $this->belongsTo(ContactInfo::class, 'wca_id', 'wca_id');
    }

    public function isMemberOfAssociation(?RegionalAssociation $association): bool
    {
        $contactInfo = $this->contact()->first();
        if (!$contactInfo) {
            return false;
        }

        if (!$association) {
            return $contactInfo->associations()->exists();
        }

        return $contactInfo->associations->contains($association->id);
    }

    public function isDSFBoardMember(): bool
    {
        $dsfAssociation = RegionalAssociation::where('wcif_identifier', 'DSF')->first();

        if (!$dsfAssociation) {
            return false;
        }

        return $this->isMemberOfAssociation($dsfAssociation);
    }
}
