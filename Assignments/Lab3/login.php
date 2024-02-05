<?php
session_start();

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $errors = false;

    // Validate email and password (you can customize the validation rules)
    $email = $_POST['email'];
    $password = $_POST['password'];

    if (empty($email)) {
        $_SESSION['email_error'] = 'An email is required.';
        $errors = true;
    }

    if (empty($password)) {
        $_SESSION['password_error'] = 'A password is required.';
        $errors = true;
    }

    // Check if the email ends with "@bcit.ca" for authentication
    if (!$errors && substr($email, -8) === '@bcit.ca') {
        $_SESSION['authenticated'] = true;
        header('Location: restricted.php');
        exit;
    }

    // If there are errors, set session messages and redirect to login.php
    if ($errors) {
        $_SESSION['email'] = $email;
        header('Location: login.php');
        exit;
    }

    // Redirect to index.php when valid email and password are provided
    header('Location: index.php?email=' . urlencode($email));
    exit;
}
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100 h-screen flex items-center justify-center">

    <div class="max-w-md w-full p-6 bg-white rounded-md shadow-md">
        <h2 class="text-3xl font-extrabold text-gray-700">Login</h2>

        <form action="login.php" method="post" class="mt-4">

            <div>
                <span class="text-red-500">
                    <?php
                        if (isset($_SESSION['email_error'])) {
                            echo $_SESSION['email_error'];
                            unset($_SESSION['email_error']);
                            }
                    ?>
                </span>
                <label for="email" class="block text-sm font-medium text-gray-700"> Email address </label>
                <div class="mt-1">
                    <input id="email" name="email" type="text" autocomplete="email" value="<?php echo isset($_SESSION['email']) ? $_SESSION['email'] : '' ?>" class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                </div>
            </div>

            <div class="space-y-1">
                <span class="text-red-500">
                    <?php
                        if (isset($_SESSION['password_error'])) {
                            echo $_SESSION['password_error'];
                            unset($_SESSION['password_error']);
                        }
                    ?>
                </span>
                <label for="password" class="block text-sm font-medium text-gray-700"> Password </label>
                <div class="mt-1">
                    <input id="password" name="password" type="password" autocomplete="current-password" class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                </div>
            </div>

            <button type="submit" name="login" class="mt-4 bg-indigo-500 text-white p-2 rounded-md">Login</button>
        </form>
    </div>

</body>

</html>
