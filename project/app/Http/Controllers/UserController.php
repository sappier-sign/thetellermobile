<?php
/**
 * Created by PhpStorm.
 * User: MEST
 * Date: 5/1/2017
 * Time: 1:02 PM
 */

namespace App\Http\Controllers;


use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
	protected $authUser = null;

	/**
	 * @return null
	 */
	public function getAuthUser()
	{
		return $this->authUser;
	}

	/**
	 * @param null $authUser
	 */
	public function setAuthUser( $authUser )
	{
		$this->authUser = $authUser;
	}


	function __construct(Request $request)
	{
		$user = User::isLoggedIn($request);
		if ($user){
			$this->setAuthUser($user);
		}
	}

	public function index()
	{
		return User::all();
	}

	public static function store(Request $request)
	{
		return User::store($request->all());
	}

	public static function show( Request $request )
	{
		return User::login($request);
	}

	public function update( Request $request )
	{
		$user = $this->getAuthUser();

		$user->userTitle 		= ucwords(strtolower($request->input('userTitle', $user->userTitle)));
		$user->userFirstName 	= ucwords(strtolower($request->input('userFirstName', $user->userFirstName)));
		$user->userLastName 	= ucwords(strtolower($request->input('userLastName', $user->userLastName)));
		$user->userPin	 		= $request->input('userPin', $user->userPin);
		$user->userGender 		= ucwords(strtolower($request->input('userGender', $user->userGender)));
		$user->userDOB			= $request->input('userDOB', $user->userDOB);
		$user->userRegion		= ucwords(strtolower($request->input('userRegion', $user->userRegion)));
		$user->userCity			= ucwords(strtolower($request->input('userCity', $user->userCity)));
		$user->userResAddress	= $request->input('userAddress', $user->userResAddress);
		$user->userStatus		= $request->input('userStatus', $user->userStatus);
		$user->phoneActivation  = $request->input('phoneActivation', $user->phoneActivation);

		if ($user->save()){
			$user = User::find($user->userKey)->toArray();
			$user['code'] = 100;
			$user['description'] = 'Update successful';
			return $user;
		} else {
            return [
                'code' => 900,
                'description' => 'Update failed, please try again later'
            ];
        }
	}

	public function changePassword( $request )
	{
		if ($request->newPassword <> $request->confirmPassword){
			return [
				'code'	=>	900,
				'description'	=>	'Password mismatch.'
			];
		} else {
			$user = $this->getAuthUser();
			if (password_verify($request->input('oldPassword'), $user->userPassword)){
				if (password_verify($request->input('newPassword'), $user->userPassword)){
					return [
						'code'	=>	900,
						'description'	=>	'New password cannot be the same as the current password.'
					];
				} else {
					$user->userPassword = password_hash($request->input('newPassword'), PASSWORD_BCRYPT);
					if ($user->save()){
						return [
							'code'	=>	100,
							'description'	=>	'Password changed successfully.'
						];
					} else {
						return [
							'code'	=>	900,
							'description'	=>	'Password could not be change at this time, please try again later.'
						];
					}
				}
			}
		}
		return [
			'code'	=>	900,
			'description'	=>	'Old password is wrong'
		];
	}

    public function pinLogin($pin)
    {
        return User::loginUsingPin($pin, $this->getAuthUser()->userKey);
	}

    public function sendSms(Request $request)
    {
        return User::sendSms($request->numbers, $request->message, 'TheTeller');
	}
}