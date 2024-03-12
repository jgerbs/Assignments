<?php

namespace src\Controllers;

use core\Request;
use src\Repositories\UserRepository;
use src\Repositories\ArticleRepository;


class SettingsController extends Controller
{

    /**
     * Display user settings.
     * @param Request $request
     * @return void
     */
    public function index(Request $request): void
    {
        // Get the user ID from the URL parameter
        $userId = (int) $request->input('id');
        if (!$userId) {
            $this->render('error', ['message' => 'User ID not provided']);
            return;
        }
        $userRepository = new UserRepository();
        $user = $userRepository->getUserById($userId);

        if (!$user) {
            $this->render('error', ['message' => 'User not found']);
            return;
        }
        $this->render('settings', ['user' => $user]);
    }

    /**
     * Updates logged in users data in the database
     * @param Request $request
     * @return void
     */
    public function update(Request $request): void
    {
        $userRepository = new UserRepository();
        $userId = $_SESSION['user_id'];

        $user = $userRepository->getUserById($userId);

        if (!$user) {
            $this->render('error', ['message' => 'User not found']);
            return;
        }

        $name = $request->input('username');

        if (isset($_FILES['profilePhoto']) && $_FILES['profilePhoto']['error'] === UPLOAD_ERR_OK) {
            $profilePicture = $_FILES['profilePhoto'];
            $temporaryPath = $profilePicture['tmp_name'];
            $fileName = $profilePicture['name'];
        
            $destinationDirectory = $_SERVER['DOCUMENT_ROOT'] . "/images/$fileName";
            if (move_uploaded_file($temporaryPath, $destinationDirectory)) {
                $profilePicture = "images/$fileName";
                $success = $userRepository->updateUser($userId, $name, $profilePicture);
            } else {
                echo "Failed to upload profile photo.";
            }
        }
        
        $success = $userRepository->updateUser($userId, $name, $profilePicture);

        if ($success) {
            header('Location: /');
            exit();
        } else {
            $this->render('error', ['message' => 'Failed to update user information']);
            exit();
        }
    }


}
