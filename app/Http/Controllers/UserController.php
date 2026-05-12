<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Services\UserService;
use App\DTOs\UserDTO;
use App\Exceptions\NoSuchException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function __construct(
        protected UserService $userManager
    ) {}

    public function login() {
        return view('auth.login');
    }

    public function create() {
        return view('auth.register');
    }

    public function authenticate(Request $request) {
        $credentials = $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return view('welcome');
        }

        return back()->withErrors(['username' => 'Invalid credentials']);
    }

    public function store(StoreUserRequest $request) {
        $dto = new UserDTO(
            username: $request->username,
            email: $request->email,
            password: $request->password
        );
        $this->userManager->createUser($dto);
        return redirect()->route('login')->with('success', 'Account created.');
    }

    public function editPage(Request $request) {
        $user = $this->userManager->findUser($request->id);
        return view('users.edit', compact('user'));
    }

    public function storeEditUser(UpdateUserRequest $request) {
        $dto = new UserDTO(
            username: $request->username,
            email: $request->email,
            is_active: $request->is_active ?? 1
        );
        $this->userManager->updateUser($request->id, $dto);
        return redirect('/');
    }

    public function logout(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }

    public function destroy($id) {
        $this->userManager->deleteUser($id);
        return back();
    }
}
