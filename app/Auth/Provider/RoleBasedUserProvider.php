<?php


namespace App\Auth\Provider;


use App\Models\User;
use Illuminate\Auth\EloquentUserProvider;
use Illuminate\Contracts\Hashing\Hasher as HasherContract;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

class RoleBasedUserProvider extends EloquentUserProvider
{
    private $role;

    public function __construct(HasherContract $hasher, $model, $role)
    {
        parent::__construct($hasher, $model);
        $this->role = $role;
    }

    /**
     * Retrieves the name of the role.
     * Used to create join queries.
     *
     * @return string
     */
    public function getRole(): string
    {
        return $this->role;
    }

    /**
     * {@inheritdoc}
     */
    public function createModel(): User
    {
        /** @var User $user */
        $user = parent::createModel();
        return $user;
    }

    /**
     * {@inheritdoc}
     */
    public function retrieveByCredentials(array $credentials)
    {
        if (empty($credentials)) {
            return null;
        }

        // First we will add each credential element to the query as a where clause.
        // Then we can execute the query and, if we found a user, return it in a
        // Eloquent User "model" that will be utilized by the Guard instances.
        $query = $this->createQueryWithJoinAndWhere();

        foreach ($credentials as $key => $value) {
            if (!Str::contains($key, 'password')) {
                $query->where($key, $value);
            }
        }

        return $query->first();
    }

    /**
     * {@inheritdoc}
     */
    public function retrieveById($identifier)
    {
        return $this->createQueryWithJoinAndWhere()
            ->find($identifier);
    }

    /**
     * {@inheritdoc}
     */
    public function retrieveByToken($identifier, $token)
    {
        $model = $this->createModel();

        return $this->createQueryWithJoinAndWhere()
            ->where($model->getAuthIdentifierName(), $identifier)
            ->where($model->getRememberTokenName(), $token)
            ->first();
    }

    /**
     * Creates a query builder with the proper join and
     * where statements, then returns it.
     *
     * @return Builder
     */
    protected function createQueryWithJoinAndWhere(): Builder
    {
        return $this->createModel()
            ->newQuery()
            ->select('users.*')
            ->join('role_user', 'users.id', '=', 'role_user.user_id')
            ->join('roles', 'role_user.role_id', '=', 'roles.id')
            ->where('roles.name', '=', $this->getRole());
    }
}