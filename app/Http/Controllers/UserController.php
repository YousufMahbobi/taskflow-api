<?php
 
namespace App\Http\Controllers;
 
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Services\UserService;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Support\ApiResponse;
use App\Models\User;
 
class UserController extends Controller
{
    /**
     * Registering user service inside controller
     *
     */
    public function __construct(
        private readonly UserService $userService
    ) {}
 
    /**
     * List users with pagination.
     */
    public function index(Request $request): JsonResponse
    {
        $users = $this->userService->paginate(
            $request->integer('per_page', 10)
        );
 
        return ApiResponse::success(
            'Users fetched successfully',
            $users,
            'USERS_FETCHED',
            200,
            [
                'current_page' => $users->currentPage(),
                'last_page'    => $users->lastPage(),
                'total'        => $users->total(),
            ]
        );
    }
 
    /**
     * Create a new user.
     */
    public function store(StoreUserRequest $request): JsonResponse
    {
        $user = $this->userService->create($request->validated());
 
        return ApiResponse::success(
            'User created successfully',
            $user,
            'USER_CREATED',
            201
        );
    }
 
    /**
     * Show a single user.
     */
    public function show(User $user): JsonResponse
    {
        return ApiResponse::success(
            'User fetched successfully',
            $user,
            'USER_FETCHED'
        );
    }
 
    /**
     * Update a single user.
     */
    public function update(User $user, UpdateUserRequest $request): JsonResponse
    {
        $user = $this->userService->update($user, $request->validated());
 
        return ApiResponse::success(
            'User updated successfully',
            $user,
            'USER_UPDATED'
        );
    }
 
    /**
     * Delete a user.
     */
    public function destroy(User $user): JsonResponse
    {
        $this->userService->delete($user);
 
        return ApiResponse::success(
            'User deleted successfully',
             null,
            'USER_DELETED',
            200
        );
    }
}