<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Auth\Authenticatable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;

class User extends Model implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable, Authorizable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    	'userKey',
        'userFirstName',
		'userLastName',
		'userPhone',
		'userPassword',
		'userPin',
		'userEmail',
        'activationCode'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'userPassword',
		'userID'
    ];

    protected $table = 'tlr_users';
    protected $primaryKey = 'userKey';
    public $incrementing = false;

    const CREATED_AT = 'dateCreated';
    const UPDATED_AT = null;

	public static function store( $user )
	{
		$user['userFirstName']	= ucwords(strtolower($user['userFirstName']));
		$user['userLastName']	= ucwords(strtolower($user['userLastName']));
		$user['userPassword'] 	= User::passwordHash($user['userPassword']);
		$user['userKey']		= User::getUserKey();
		$user['activationCode'] = md5($user['userKey']);
		$new_user = User::create($user);

		if ($new_user->userKey){
		    $verify_number = self::verifyNumber($user['userPhone'], $new_user->userKey);
		    if ($verify_number['code'] === '000'){
		        $new_user['verification_code']    =   $verify_number['verification_code'];
            }

            $email = new Email();
		    $email->sendEmail($user['userEmail'], 'TheTeller', 'ACCOUNT VERIFICATION', $email->emailTemplate('Account Verification', $user['userEmail'], $user['userFirstName'], $user['userLastName'], $user['activationCode']));
            return $new_user;
        } else {
		    return [
		        'code'  => 100,
                'status'    =>  'failed',
                'reason'    =>  'User registration failed'
            ];
        }
    }

	private static function getUserPhone( $phone )
	{
		$country = Country::where('countryNicename', ucwords(strtolower('ghana')))->first();
		return '+'.$country->countryPhoneCode.substr($phone, 1);
    }

	private static function passwordHash( $password )
	{
		return password_hash($password, PASSWORD_BCRYPT);
    }

	private static function getUserKey()
	{
		$str = '1QAZXSW23EDCVFR45TGBNHY67UJMKI89OLP0poiuytrewqasdfghjklmnbvcxz';
		return substr(str_shuffle($str),5, 15);
    }

	public static function login( Request $request )
	{
		$user = User::where('userEmail', $request->userEmail)->first();
		if (count(json_decode($user, true)) === 0){
			return [
				'code' => 900,
				'description' => 'The email entered does not match any account, please try again.'
			];
		}

		if (!password_verify($request->userPassword, $user->userPassword)){
			return [
				'code' => 900,
				'description' => 'You entered a wrong password, please try again.'
			];
		}

		if (Carbon::parse($user->userLastLogin)->lt(Carbon::now())){
		    $user->transactions = 0;
        }

		$user->userLastLogin 	= Carbon::now();
		$user->userLoginCount 	= $user->userLoginCount + 1;
		$user->save();
		return $user;
    }

	public static function isLoggedIn($request)
	{
		if($request->hasHeader('User-Token') && $request->header('User-Token') <> null){
			return User::where('userKey', $request->header('User-Token'))->first();
		}
		return response(['code' => 900, 'description' => 'Sorry, you\'ll have to be logged in to perform this task'],403);
    }

    public static function verifyNumber($telephone, $user_id)
    {
        $headers = [
            'Content-Type: application/json'
        ];

        $curl = curl_init('https://api.theteller.net/v1.1/verify/phone_number');
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode(['phone_number' => $telephone, 'user_id' => $user_id, 'from' => 'TheTeller']));
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

        return json_decode(curl_exec($curl), true);
    }

    public static function sendSms($phone_number, $message, $sender)
    {
        $headers = [
            'Content-Type: application/json'
        ];

        $curl = curl_init('https://api.theteller.net/v1.1/sms/send');
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode(['recipients' => $phone_number, 'from' => $sender, 'message' => $message]));
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

        return json_decode(curl_exec($curl), true);
    }

    public static function loginUsingPin($pin, $user_token)
    {
       if (User::where('userPin', $pin)->where('userKey', $user_token)->count()){
           return [
               'status' =>  'success',
               'code'   =>  '000',
               'reason' =>  'user found'
           ];
       }
       return [
           'status' =>  'failed',
           'code'   =>  '100',
           'reason' =>  'user not found'
       ];
    }
}
