<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class UserApiController extends Controller
{
    /**
     * Register new user
     * POST /api/register
     */
    public function register(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|string|min:6|confirmed'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validasi gagal',
                    'errors' => $validator->errors()
                ], 422);
            }

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password)
            ]);

            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                'success' => true,
                'message' => 'Registrasi berhasil',
                'data' => [
                    'user' => $user,
                    'token' => $token
                ]
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Registrasi gagal',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Login user
     * POST /api/login
     */
    public function login(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'email' => 'required|email',
                'password' => 'required'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validasi gagal',
                    'errors' => $validator->errors()
                ], 422);
            }

            if (!Auth::attempt($request->only('email', 'password'))) {
                return response()->json([
                    'success' => false,
                    'message' => 'Email atau password salah'
                ], 401);
            }

            $user = User::where('email', $request->email)->first();
            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                'success' => true,
                'message' => 'Login berhasil',
                'data' => [
                    'user' => $user,
                    'token' => $token
                ]
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Login gagal',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Logout user
     * POST /api/logout
     */
    public function logout(Request $request)
    {
        try {
            $request->user()->currentAccessToken()->delete();

            return response()->json([
                'success' => true,
                'message' => 'Logout berhasil'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Logout gagal',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display a listing of users.
     * GET /api/users
     */
    public function index()
    {
        try {
            $users = User::all();

            return response()->json([
                'success' => true,
                'message' => 'Data users berhasil diambil',
                'data' => $users
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data users',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified user.
     * GET /api/users/{id}
     */
    public function show($id)
    {
        try {
            $user = User::find($id);

            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'User tidak ditemukan'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'message' => 'Detail user berhasil diambil',
                'data' => $user
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil detail user',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update the specified user.
     * PUT /api/users/{id}
     */
    public function update(Request $request, $id)
    {
        try {
            $user = User::find($id);

            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'User tidak ditemukan'
                ], 404);
            }

            $validator = Validator::make($request->all(), [
                'name' => 'sometimes|string|max:255',
                'email' => 'sometimes|email|unique:users,email,' . $id,
                'password' => 'sometimes|string|min:6'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validasi gagal',
                    'errors' => $validator->errors()
                ], 422);
            }

            $data = $request->only(['name', 'email']);
            if ($request->has('password')) {
                $data['password'] = Hash::make($request->password);
            }

            $user->update($data);

            return response()->json([
                'success' => true,
                'message' => 'User berhasil diupdate',
                'data' => $user
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengupdate user',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified user.
     * DELETE /api/users/{id}
     */
    public function destroy($id)
    {
        try {
            $user = User::find($id);

            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'User tidak ditemukan'
                ], 404);
            }

            $user->delete();

            return response()->json([
                'success' => true,
                'message' => 'User berhasil dihapus'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus user',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
