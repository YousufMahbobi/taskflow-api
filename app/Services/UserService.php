<?php
 
namespace App\Services;
 
use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
 
class UserService
{
    /**
     * Paginate users list.
     */
    public function paginate(int $perPage = 15): LengthAwarePaginator
    {
        return User::paginate($perPage);
    }
 
    /**
     * Create a new user with optional avatar upload
     * @throws \Throwable
     */
    public function create(array $data): User
    {
        return DB::transaction(function () use ($data): User {
 
            if(isset($data['password'])){
                $data['password'] = Hash::make($data['password']);
            }
 
            if(isset($data['avatar'])){
                $data['avatar'] = $data['avatar']->store('avatars', 'public');
            }
 
            return User::create($data);
        });
    }
 
    /**
     * Update an existing user and safely replace avatar if provided.
     * @throws \Throwable
     */
    public function update(User $user, array $data): User
    {
        return DB::transaction(function () use ($user, $data): User {
 
            if(!empty($data['password'])){
                $data['password'] = Hash::make($data['password']);
            }else{
                unset($data['password']);
            }
 
            if(isset($data['avatar'])){
                if($user->avatar && Storage::disk('public')->exists($user->avatar)){
                    Storage::disk('public')->delete($user->avatar);
                }
 
                $data['avatar'] = $data['avatar']->store('avatars', 'public');
            }
 
            $user->update($data);
 
            return $user;
 
        });
    }
 
    /**
     * Delete a user and its associated avatar.
     * @throws \Throwable
     */
    public function delete(User $user): void
    {
        DB::transaction(function () use ($user): void {
 
            if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
                Storage::disk('public')->delete($user->avatar);
            }
 
            $user->delete();
        });
    }
 
}