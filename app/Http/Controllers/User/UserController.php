<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\User\UserResource;
use App\Models\User;
use App\Services\User\UserSectionFilter;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Spatie\QueryBuilder\QueryBuilder;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $userFilter = new UserSectionFilter();
        $queryItems = $userFilter->transform($request);

        $query = QueryBuilder::for(User::class)
            ->allowedSorts(['username', 'email', 'fullname', 'shortname', 'created_at', 'updated_at']);

        foreach ($queryItems as $filter) {
            $query->where($filter[0], $filter[1], $filter[2]);
        }

        if ($request->has('limit')) {
            $users = $query->paginate($request->query('limit'));
        } else {
            $users = $query->paginate();
        }

        $users->getCollection()->transform(function ($user) {
            return $user;
        });

        return UserResource::collection($users);
    }

    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'urole_id' => 'required',
                'username' => 'required',
                'email' => 'required|email',
                'password' => 'required',
                'fullname' => 'required',
                'shortname' => 'required',
                'avatar' => 'required',
                'phone' => 'required',
                'status' => 'required',
            ]);

            $hashedPassword = Hash::make($validatedData['password']);
            $validatedData['password'] = $hashedPassword;

            $user = User::create($validatedData);

            return response()->json([
                'message' => 'User created successfully',
                'data' => new UserResource(($user)),
            ], 201);
        } catch (ValidationException $err) {
            return response()->json([
                'error' => 'Validation failed',
                'message' => $err->errors(),
            ], 422);
        }
    }

    public function show($id)
    {
        $roleId = User::findOrFail($id);

        return new UserResource($roleId);
    }

    public function update(Request $request, $id)
    {
        try {
            $user = User::findOrFail($id);

            $validatedData = $request->validate([
                'username' => 'string|max:100',
                'urole_id' => 'sometimes|required',
                'username' => 'sometimes|required',
                'email' => 'sometimes|required|email',
                'password' => 'sometimes|required',
                'fullname' => 'sometimes|required',
                'shortname' => 'sometimes|required',
                'avatar' => 'sometimes|required',
                'phone' => 'sometimes|required',
                'status' => 'sometimes|required',
            ]);

            $user->update($validatedData);

            return response()->json([
                'message' => 'User updated successfully',
                'data' => new UserResource($user),
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => 'User not found',
                'message' => $e->getMessage(),
            ], 404);
        } catch (ValidationException $e) {
            return response()->json([
                'error' => 'Validation failed',
                'message' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to update user',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $role = User::findOrFail($id);
            $role->delete();

            return response()->json([
                'message' => 'User deleted successfully',
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => 'User not found with provided ID',
                'message' => $e->getMessage(),
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to delete User',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function change_password(Request $request, $id)
    {
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|min:8',
        ]);

        $user = User::findOrFail($id);

        if (!Hash::check($request->old_password, $user->password)) {
            return response()->json(['error' => 'Password lama tidak cocok'], 400);
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        return response()->json(['message' => 'Password berhasil diubah'], 200);
    }
}
