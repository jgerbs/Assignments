<?php

namespace src\Controllers;

use core\Request;
use src\Repositories\UserRepository;


class LoginController extends Controller
{

	/**
	 * Show the login page.
	 * @return void
	 */
	public function index(): void
	{
		$this->render('login');
	}

	/**
	 * Process the login attempt.
	 * @param Request $request
	 * @return void
	 */
	public function login(Request $request): void
		{
		$email = $request->input('email');
		$password = $request->input('password');

		$userRepository = new UserRepository();
		$user = $userRepository->getUserByEmail($email);


		if (!($user->email === $email)){
			$this->render('login', ['error' => 'Invalid Email']);

		}
		elseif (!password_verify($password, $user->password_digest)) {
			$this->render('login', ['error' => 'Incorrect Password']);
		}
		if ($user !== $email){
			if (password_verify($password, $user->password_digest)) {
			$_SESSION['user_id'] = $user->id;
			header('Location: /');
			exit();
			}
		} else {
			// Incorrect email or password, redirect back to the login page
			$this->render('login', ['error' => 'Password']);
		}
	}

}
