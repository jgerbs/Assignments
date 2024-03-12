<?php

namespace src\Controllers;

class LogoutController extends Controller
{

	/**
	 * Destroys the current session logging out the user
	 */
	public function logout()
	{
		session_destroy();
		$this->redirect('/login');
	}
}
