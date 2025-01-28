<?php

declare(strict_types=1);

namespace Orchid\Access;

use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Orchid\Platform\Models\User;
use Orchid\Support\Facades\Dashboard;

trait RoleAccess
{
    use StatusAccess;

    /**
     * Get the primary key for the role
     *
     * @return int|string|null
     */
    public function getRoleId()
    {
        return $this->getKey();
    }

    /**
     * Get the slug of the role
     *
     * @return string
     */
    public function getRoleSlug(): string
    {
        return $this->getAttribute('slug');
    }

    /**
     * Get the users assigned to the role
     *
     * @return Collection
     */
    public function getUsers(): Collection
    {
        return $this->users()->get();
    }

    /**
     * Define the relationship with the users assigned to the role
     *
     * @return BelongsToMany
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(Dashboard::model(User::class), 'role_users', 'role_id', 'user_id');
    }

    /**
     * Get the number of permissions assigned to the role
     *
     * @return int
     */
    public function getCountPermissions(): int
    {
        return collect($this->permissions)->filter(fn (int $value) => $value)->count();
    }

    /**
     * Override the deleted method to detach the users assigned to the role
     * before deleting the role
     *
     * @throws Exception
     */
    public function delete(): ?bool
    {
        $isSoftDeleted = array_key_exists(SoftDeletes::class, class_uses($this));

        if ($this->exists && ! $isSoftDeleted) {
            $this->users()->detach();
        }

        return parent::delete();
    }
}
