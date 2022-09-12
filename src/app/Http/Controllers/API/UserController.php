<?php

namespace App\Http\Controllers\API;

use App\Events\UserCreatedEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Http\Resources\API\UserResource;
use App\Models\User;
use App\traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class UserController extends Controller
{
    use ApiResponse;

    /**
     * Display a listing of the users.
     */
    public function index(): JsonResponse
    {
        $users = User::with('roles')->paginate();

        return $this->response(Response::HTTP_OK, UserResource::collection($users));
    }

    /**
     * Store a new User data.
     */
    public function store(UserRequest $request): JsonResponse
    {
        $user = User::create($request->validated());
        $user->roles()->attach($request->roles);
        UserCreatedEvent::dispatch($user);

        return $this->response(Response::HTTP_CREATED, new UserResource($user));
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user): JsonResponse
    {
        return $this->response(Response::HTTP_OK, new UserResource($user));
    }

    /**
     * Update the specified user.
     */
    public function update(UserRequest $request, User $user): JsonResponse
    {
        $user->update($request->validated());
        $user->roles()->sync($request->roles);

        return $this->response(Response::HTTP_OK, new UserResource($user->refresh()));
    }

    /**
     * Remove the user from the database.
     */
    public function destroy(User $user): JsonResponse
    {
        $user->roles()->sync([]);
        $user->delete();

        return $this->response(Response::HTTP_OK);
    }
}
