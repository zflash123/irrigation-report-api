<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\User\RoleResource;
use App\Models\UserRole;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class RoleController extends Controller
{
    public function index()
    {
        $role = UserRole::paginate();

        return RoleResource::collection($role);
    }

    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'name' => 'required|string|max:100',
                'code' => 'required|string|max:100',
                'desc' => 'nullable|string|max:255',
            ]);

            $role = UserRole::create($validatedData);

            return response()->json([
                'message' => 'Role created successfully',
                'data' => new RoleResource(($role)),
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
        $roleId = UserRole::findOrFail($id);

        return new RoleResource($roleId);
    }

    public function update(Request $request, $id)
    {
        try {
            $role = UserRole::findOrFail($id);

            $validatedData = $request->validate([
                'name' => 'string|max:100',
                'code' => 'string|max:100',
                'desc' => 'nullable|string|max:255',
            ]);

            $role->update($validatedData);

            return response()->json([
                'message' => 'Role updated successfully',
                'data' => new RoleResource($role),
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => 'Role not found',
                'message' => $e->getMessage(),
            ], 404);
        } catch (ValidationException $e) {
            return response()->json([
                'error' => 'Validation failed',
                'message' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to update role',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $role = UserRole::findOrFail($id);
            $role->delete();

            return response()->json([
                'message' => 'Role deleted successfully',
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => 'Role not found with provided ID',
                'message' => $e->getMessage(),
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to delete role',
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
