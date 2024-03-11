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
        $profilePicture = null;

        if (isset($_FILES['profilePhoto']) && $_FILES['profilePhoto']['error'] === UPLOAD_ERR_OK) {
            // Handle file upload logic here
            // ...

            // Update the $profilePicture variable with the path to the uploaded file
        }

        $success = $userRepository->updateUser($userId, $name, $profilePicture);

        if ($success) {
            header('Location: /settings');
            exit();
        } else {
            $this->render('error', ['message' => 'Failed to update user information']);
            exit();
        }
    }


    /**
     * Handle profile image upload.
     * @param Request $request
     * @return void
     */
    public function uploadImage(Request $request): void
    {
        // Handle image upload logic
        // ...

        // Redirect back to the settings page after image upload
        $this->redirect('/settings');
    }
}
