<?php

/**
 * Description of UITools
 *
 * @author joemmanuel
 */
class UITools {

	public static $IsLoggedIn = false;

	/**
	 * Set rank by problems solved
	 * 
	 * @param Smarty smarty
	 * @param int $offset
	 * @param int $rowcount
	 */
	public static function setRankByProblemsSolved(Smarty $smarty, $offset, $rowcount) {

		$rankRequest = new Request(array("offset" => $offset, "rowcount" => $rowcount));
		$response = UserController::getRankByProblemsSolved($rankRequest);

		$smarty->assign('rank', $response);
	}

	/**
	 * If user is not logged in, redirect to login page
	 */
	public static function redirectToLoginIfNotLoggedIn() {

		if (self::$IsLoggedIn === false) {
			header("Location: /login.php?redirect=" . $_SERVER["REQUEST_URI"]);
			die();
		}
	}

	/**
	 * Set profile in smarty var
	 * 
	 * @param Smarty $smarty
	 */
	public static function setProfile(Smarty $smarty) {
		$profileRequest = new Request(array(
					"username" => $_REQUEST["username"],
					"auth_token" => $smarty->getTemplateVars('CURRENT_USER_AUTH_TOKEN')
				));
		$response = UserController::apiProfile($profileRequest);
		$response["userinfo"]["graduation_date"] = is_null($response["userinfo"]["graduation_date"]) ? 
				null : gmdate('d/m/Y', $response["userinfo"]["graduation_date"]);
		
		$response["userinfo"]["birth_date"] = is_null($response["userinfo"]["birth_date"]) ? 
				null : gmdate('d/m/Y', $response["userinfo"]["birth_date"]);
		
		$smarty->assign('profile', $response);
	}

}
