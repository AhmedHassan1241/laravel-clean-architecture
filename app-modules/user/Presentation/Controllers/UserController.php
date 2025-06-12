<?php

namespace AppModules\User\Presentation\Controllers;

use AppModules\User\Application\DTOs\LoginUserDTO;
use AppModules\user\Application\DTOs\RegisterUserDTO;
use AppModules\User\Application\DTOs\UpdateUserDTO;
use AppModules\User\Application\Services\AuthService;
use AppModules\User\Application\UseCases\DeleteUserUseCase;
use AppModules\User\Application\UseCases\GetAllUserCase;
use AppModules\User\Application\UseCases\GetUserByIdUseCase;
use AppModules\User\Application\UseCases\LoginUserUseCase;
use AppModules\User\Application\UseCases\RegisterUserUseCase;
use AppModules\user\Presentation\Requests\LoginUserRequest;
use AppModules\user\Presentation\Requests\RegisterUserRequest;
use AppModules\User\Presentation\Requests\UpdateUserRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;

class UserController extends Controller
{

    public function __construct(private RegisterUserUseCase $registerUserUseCase, private LoginUserUseCase $loginUserUseCase, private AuthService $authService)
    {
    }

    public function register(RegisterUserRequest $request): JsonResponse  //RegisterUserRequest for validate request
    {
        $data = $request->validated();

        $userDTO = new RegisterUserDTO($data['name'], $data['email'], $data['password']);
        $user = $this->registerUserUseCase->execute($userDTO);

        return response()->json([
            'message' => 'User created successfully',
            'user' => $user
        ], 201);
    }

    public function login(LoginUserRequest $request): JsonResponse
    {
        $data = $request->validated();
        $userDTO = new LoginUserDTO($data['email'], $data['password']);
        $user = $this->loginUserUseCase->execute($userDTO);
        // ✅ اجلب الـ UserModel باستخدام الايميل أو الـ id من الكائن الدومين
        $token = $this->authService->generateToken($user);
        //        return response()->json($user);
        return response()->json([
            'message' => 'Login successful',
            'token' => $token,
            'user' => [
                'id' => $user->getId(),
                'name' => $user->getName(),
                'email' => $user->getEmail(),
            ]
        ]);

    }


    public function index(GetAllUserCase $useCase): JsonResponse
    {
        $users = $useCase->execute();
        return response()->json($users);
    }

    public function show(int $id, GetUserByIdUseCase $useCase): JsonResponse
    {
        $user = $useCase->execute($id);
        if (!$user) {
            return response()->json(['message' => "User Not Found !!"], 404);
        }
        return response()->json($user);
    }

    public function update(int $id, UpdateUserRequest $updateUserRequest): JsonResponse
    {
        $data = $updateUserRequest->validated();
        $updateUserDTO = new UpdateUserDTO($id, $data['name'] ?? '', $data['email'] ?? '', $data['password'] ?? null);
        $updateUser = $this->updateUserUseCase->execute($id, $updateUserDTO);
        return response()->json(['message' => "User Updated Successfully", 'User' => $updateUser], 200);

    }

    public function delete(int $id, DeleteUserUseCase $useCase): JsonResponse
    {
        $user = $useCase->execute($id);
        if (!$user) {
            return response()->json(["message" => "User Not Found !!"], 404);

        }

        return response()->json(["message" => "User Deleted Successfully "], 200);

    }

}
