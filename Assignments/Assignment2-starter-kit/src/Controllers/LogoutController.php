<?php

namespace src\Controllers;

class LogoutController extends Controller
{

	public function logout()
	{
		session_destroy();
		$this->redirect('/login');
	}
}
