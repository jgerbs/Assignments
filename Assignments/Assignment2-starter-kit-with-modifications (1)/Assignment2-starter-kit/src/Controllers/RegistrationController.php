<?php

namespace src\Controllers;

use core\Request;
use PDOException;
use src\Repositories\UserRepository;

class RegistrationController extends Controller
{
    /**
     * @return void
     */
    public function index(): void
    {
        $this->render('register');
    }

    /**
     * Allows user to register for an account if the data is valid
     */
    public function register(Request $request): void
    {
        $name = $request->input('name');
        $email = $request->input('email');
        $password = $request->input('password');
        $minLength = 8;
        $symbolRegex = '/[!@#$%^&*(),.?":{}|<>]/';
    
        if (strlen($password) < $minLength || !preg_match($symbolRegex, $password)){
                $this->render('register', ['error' => "Invalid Password"]);
                exit();
            }
        

        if($password)
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]);
        $userRepository = new UserRepository();
        
		try {
			if ($userRepository->getUserByEmail($email)) {
				throw new PDOException('Email address is already registered.');
			}
		
            $user = $userRepository->saveUser($name, $email, $hashedPassword);
            $loginController = new LoginController();
            $loginController->login($request);
			$_SESSION['user_id'] = $user->id;
		
			header('Location: /');
			exit(); 
		} catch (PDOException $e) {
			$this->render('register', ['error' => $e->getMessage()]);
		}
    }
}
