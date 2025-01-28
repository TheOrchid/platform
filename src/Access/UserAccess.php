<?php

declare(strict_types=1);

namespace Orchid\Access;

use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Orchid\Platform\Events\AddRoleEvent;
use Orchid\Platform\Events\RemoveRoleEvent;
use Orchid\Platform\Models\Role;
use Orchid\Support\Facades\Dashboard;

trait UserAccess
{
    use StatusAccess;

    /**
     * @var null|\Illuminate\Support\Collection
     */
    private $cachePermissions;

    /**
     * @return Collection
     */
    public function getRoles()
    {
        return $this->roles()->get();
    }

    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Dashboard::model(Role::class), 'role_users', 'user_id', 'role_id');
    }

    /**
     * @param Role|int|string $role
     */
    public function inRole($role): bool
    {
        $role = Arr::first($this->roles, static function ($instance) use ($role) {
            if ($role instanceof RoleInterface) {
                return $instance->getRoleId() === $role->getRoleId();
            }
            if ($role === $instance->getRoleId() || $role === $instance->getRoleSlug()) {
                return true;
            }

            return false;
        });

        return $role !== null;
    }

    public function hasAccess(string $permit, bool $cache = true): bool
    {
        if (! $cache || $this->cachePermissions === null) {
            $this->cachePermissions = $this->roles()
                ->pluck('permissions')
                ->prepend($this->permissions)
                ->filter(fn ($permission) => is_array($permission));
        }

        return $this->cachePermissions
            ->filter(fn (array $permissions) => $this->filterWildcardAccess($permissions, $permit))
            ->isNotEmpty();
    }

    /**
     * Permissions can be checked based on wildcards
     * using the * character to match any of a set of permissions.
     */
    protected function filterWildcardAccess(array $permissions, string $permit): bool
    {
        return collect($permissions)
            ->filter(fn (bool $value, $permission) => Str::is($permit, $permission) && $value)
            ->isNotEmpty();
    }

    /**
     * This method will grant access if any permission passes the check.
     *
     * @param string|iterable $permissions
     */
    public function hasAnyAccess($permissions, bool $cache = true): bool
    {
        if (empty($permissions)) {
            return true;
        }

        return collect($permissions)
            ->map(fn (string $permit) => $this->hasAccess($permit, $cache))
            ->filter(fn (bool $result) => $result === true)
            ->isNotEmpty();
    }

    /**
     * Query Scope for retreiving users by a certain permission
     * The * character usage is not implemented.
     */
    public function scopeByAccess(Builder $builder, string $permitWithoutWildcard): Builder
    {
        if (empty($permitWithoutWildcard)) {
            return $builder->whereRaw('1=0');
        }

        return $this->scopeByAnyAccess($builder, $permitWithoutWildcard);
    }

    /**
     * Query Scope for retreiving users by any permissions
     * The * character usage is not implemented.
     *
     * @param string|iterable $permitsWithoutWildcard
     */
    public function scopeByAnyAccess(Builder $builder, $permitsWithoutWildcard): Builder
    {
        $permits = collect($permitsWithoutWildcard);

        if ($permits->isEmpty()) {
            return $builder->whereRaw('1=0');
        }

        $rule = function (Builder $builder, \Illuminate\Support\Collection $permits) {
            $permits->each(function ($permit) use ($builder) {
                $builder->orWhere('permissions->'.$permit, true);
            });
        };

        return $builder
            ->where(function (Builder $builder) use ($permits, $rule) {
                $rule($builder, $permits);
            })
            ->orWhereHas('roles', function (Builder $builder) use ($permits, $rule) {
                $builder->where(function (Builder $builder) use ($permits, $rule) {
                    $rule($builder, $permits);
                });
            });
    }

    public function addRole(Model $role): Model
    {
        $result = $this->roles()->save($role);

        $this->eventAddRole($role);

        return $result;
    }

    /**
     * Remove Role Slug.
     */
    public function removeRoleBySlug(string $slug): int
    {
        $role = $this->roles()->where('slug', $slug)->first();

        if ($role === null) {
            return 0;
        }

        $this->eventRemoveRole($role);

        return $this->roles()->detach($role);
    }

    /**
     * @return int|null
     */
    public function removeRole(RoleInterface $role): int
    {
        return $this->removeRoleBySlug($role->getRoleSlug());
    }

    /**
     * @return $this
     */
    public function replaceRoles(?array $roles = [])
    {
        $this->roles()->detach();

        $this->eventRemoveRole($roles);

        $this->roles()->attach($roles);

        $this->eventAddRole($roles);

        return $this;
    }

    /**
     * @param Model|RoleInterface|RoleInterface[] $roles
     */
    public function eventAddRole($roles)
    {
        event(new AddRoleEvent($this, $roles));
    }

    /**
     * @param Model|RoleInterface|RoleInterface[] $roles
     */
    public function eventRemoveRole($roles)
    {
        event(new RemoveRoleEvent($this, $roles));
    }

    /**
     * @throws Exception
     */
    public function delete(): bool
    {
        $isSoftDeleted = array_key_exists(SoftDeletes::class, class_uses($this));

        if ($this->exists && ! $isSoftDeleted) {
            $this->roles()->detach();
        }

        return parent::delete();
    }

    public function clearCachePermission(): self
    {
        $this->cachePermissions = null;

        return $this;
    }
}
