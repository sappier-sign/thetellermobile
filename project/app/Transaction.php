<?php
/**
 * Created by PhpStorm.
 * User: MEST
 * Date: 5/10/2017
 * Time: 2:02 PM
 */

namespace App;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Transaction extends Model
{
	protected $table		= 'tlr_transactions';
	protected $primaryKey	= 'transactionKey';
	public $incrementing	= false;

	protected $hidden		= [
		'transactionExtraData',
		'userKey'
	];

    public function service()
    {
        return $this->belongsTo(Service::class, 'serviceKey', 'serviceKey');
	}

	protected $fillable 	= [
		'transactionKey',
		'userKey',
		'serviceKey',
		'providerKey',
		'transactionAmount',
		'trasactionCharge',
		'billingAmount',
		'paymentSourceKey',
		'transactionRRN',
		'transactionSRN',
		'transactionDesc',
		'transactionDate',
		'transactionTime',
		'transactionStatus',
		'transactionExtraData'
	];

	const CREATED_AT = null;
	const UPDATED_AT = null;

	public function __construct()
	{
		ini_set('max_execution_time', 120);
		ini_set('display_errors', 1);
	}

	public function services()
	{
		return $this->hasMany(Service::class, 'serviceKey', 'serviceKey');
	}

	public static function performTransaction( $data )
	{
	    $response = [];
		$momo = [
			'hkJjfRplinyqTSM',
			'eVbK8jYX244dUsY',
			'dlBmL22jz5U843O',
			'hPQoQpio3Q6GbYe'
		];

		$cards = [
			'cuI6w81aBKse1JK',
			'dzbZ9nl3P59qtgM'
		];

		$mode = '';

		if ($data['paymentSourceKey'] === 'hkJjfRplinyqTSM'){
			$mode = 'mtn';
		} elseif ($data['paymentSourceKey'] === 'hPQoQpio3Q6GbYe'){
			$mode = 'airtel';
		} elseif ($data['paymentSourceKey'] === 'eVbK8jYX244dUsY'){
			$mode = 'tigo';
		} elseif ($data['paymentSourceKey'] === 'dlBmL22jz5U843O'){
			$mode = 'vodafone';
		} elseif ($data['paymentSourceKey'] === 'cuI6w81aBKse1JK'){
			$mode = 'mastercard';
            $data['number'] = $data['pan'];
		} elseif ($data['paymentSourceKey'] === 'dzbZ9nl3P59qtgM'){
			$mode = 'visa';
            $data['number'] = $data['pan'];
		} elseif ($data['paymentSourceKey'] === 'bMZaixFri1TvqA6'){
			$mode = 'ghlink';
		}

		$number = $data['number'];
		unset($data['number']);

        if (isset($data['desc'])) {
            $desc = $data['desc']; unset($data['desc']);
        } else {
            $desc = null;
        }

        if (!isset($data['recipient'])) {
            $data['recipient'] = null;
        }

        if (!isset($data['network'])) { // Must validate for funds transfer
            $data['network'] = null;
        }

        $userTransactions = Transaction::where('userKey', $data['userKey'])->whereDate('transactionDate', Carbon::now()->toDateString())->get();
        $transacted_amount = 0.00;
        foreach ($userTransactions as $userTransaction) {
            if ($userTransaction->transactionStatus == 1)
            $transacted_amount += (float) $userTransaction->billingAmount;
        }

        if ((float)$transacted_amount >= 300.00){
            return [
                'status' => 'failed',
                'code'   => 233,
                'reason' => 'You have exceeded your limit of GHS 300.00. Please try again tomorrow!'
            ];
        }

        if (((float)($transacted_amount + (float)$data['billingAmount'])) > 300){
            return [
                'status' => 'failed',
                'code'   => 233,
                'reason' => 'Amount left to hit your daily limit is '.number_format((float) (300 - (float)$transacted_amount), 2)
            ];
        }

		$class = new Transaction();
		$class->transactionKey 		= $data['transactionKey'];
		$class->userKey 			= $data['userKey'];
		$class->serviceKey 			= $data['serviceKey'];
		$class->providerKey 		= $data['providerKey'];
		$class->transactionAmount 	= $data['transactionAmount'];
		$class->trasactionCharge 	= $data['transactionCharge'];
		$class->billingAmount 		= $data['billingAmount'];
		$class->paymentSourceKey 	= $data['paymentSourceKey'];
		$class->transactionRRN 		= $data['transactionRRN'];
		$class->transactionSRN 		= $data['transactionSRN'];
		$class->transactionDesc 	= $data['transactionDesc'];
		$class->transactionDate 	= $data['transactionDate'];
		$class->transactionTime 	= $data['transactionTime'];
		$class->transactionExtraData = $data['transactionExtraData'];
		
		$class->save();

        $user = User::where('userKey', $class->userKey)->first();
        $service_provider = DB::table('tlr_services_providers')->where('providerKey', $class->providerKey)->first()->companyName;

        $transaction_id = str_shuffle(substr(explode(' ', microtime())[1], 0, 4).explode('.', explode(' ', microtime())[0])[1]);
		if ($data['serviceKey'] === 'eoODpCgB9bpusCu'){
			if (in_array($data['paymentSourceKey'], $cards)){
				$response = $class->transfer(
				    $mode,
                    $number,
                    number_format((float) $data['billingAmount'], 2),
                    $data['transactionKey'],
                    $desc,
                    $data['recipient'],
                    $data['network'],
                    $data['transactionAmount'],
                    $data['expMonth'],
                    $data['expYear'],
                    $data['cvv'],
                    null,
                    $transaction_id,
                    $data['url']
                );
			} else {
				$response = $class->transfer($mode, $number, number_format((float) $data['billingAmount'], 2), $transaction_id, $desc, $data['recipient'], $data['network'], number_format((float) $data['transactionAmount'], 2));
			}

            if ($response['code'] === '000'){
			    if ($data['network'] === 'mtn'){
			        $wallet = 'MTN Mobile Money Wallet';
                } elseif ($data['network'] === 'airtel') {
			        $wallet = 'Airtel Money Wallet';
                } elseif ($data['network'] === 'tigo'){
			        $wallet = 'Tigo Cash Wallet';
                } elseif ($data['network'] === 'vodafone'){
                    $wallet = 'Vodafone Cash Wallet';
                } else {
                    $wallet = 'wallet';
                }
                $message = "Hi $user->userFirstName, you have successfully transferred GHS".$data['transactionAmount']." to ".$data['recipient']." Your transaction id is $transaction_id. Thank you for using TheTeller!";
                $recipient_msg = "$user->userFirstName $user->userLastName has sent GHS".$data['transactionAmount']." to your $wallet. Send and receive money instantly with TheTeller https://theteller.net.";
            } else {
                $message = "Hi $user->userFirstName, your transfer of GHS".$data['transactionAmount']." to ".$data['recipient']." was not successful. ".$response['reason']." Your transaction id is $transaction_id. Thank you for using TheTeller!";
            }

		} else {

			if (in_array($data['paymentSourceKey'], $momo)){

				$response = $class->debit( $mode, $number, number_format((float) $data['billingAmount'], 2), $transaction_id, $desc);

			} elseif (in_array($data['paymentSourceKey'], $cards)){

				$response = $class->debit( $mode, $number, number_format((float) $data['billingAmount'], 2), $transaction_id, $desc, $data['expMonth'], $data['expYear'], null, $data['cvv'], $data['url']);
			}

            if ($response['code'] === '000'){
                $message = "Hi $user->userFirstName, you have successfully paid GHS".$data['transactionAmount']." to $service_provider. Your transaction id is $transaction_id. Thank you for using TheTeller!";
            } else {
                $message = "Hi $user->userFirstName, payment of GHS".$data['transactionAmount']." to $service_provider was not successful. ".$response['reason']." Your transaction id is $transaction_id. Thank you for using TheTeller!";
            }
		}

		if (isset($response['code']) && $response['code'] === '000'){
		    $class->transactionStatus = 1;
		    $user->transactions = $user->transactions + 1;
		    $user->save();
        } elseif (isset($response['code']) && $response['code'] === '991'){
            $class->transactionStatus = 0;
            User::sendSms(['233249621938'], 'Suspicious transaction detected on TheTeller', 'TheTeller');
        } else {
            $class->transactionStatus = 0;
        }
        $class->save();

		if ($response['status'] <> 'vbv required'){ // Check if payment is not vbv required
            User::sendSms([$user->userPhone], $message, 'TheTeller'); // Send Account holder a message
            if (isset($recipient_msg)){ // Check if the recipient's message has been composed
                User::sendSms(['233'.substr($data['recipient'], 1)], $recipient_msg, 'TheTeller'); // Send recipient a message
            }
        }

		return $response;
	}

	private function transfer( $wallet_id, $number, $amount, $id, $desc, $recipient = null, $network, $transacted_amount, $expMonth = null, $expYear = null, $cvv = null, $pin = null, $ref = null, $url = null )
	{
	    if ($amount > 300.00){ // Check if the amount is less than ghc 300.00
	        return [
	            'status'    =>  'failed',
                'code'      =>  '0',
                'reason'    =>  'GHS '.$amount.' is above the allowed amount of GHS 300.00.'
            ];
        }

	    $r_switch       =   self::getRswitch($mode);
	    $account_issuer =   self::getRswitch($network);
	    $request    =   [
	        'merchant_id'   =>  'TTM-00000002',
            'wallet_id'     =>  $wallet_id,
			'processing_code'	=>	'40'.self::isMobileWallet($r_switch, 'from').self::isMobileWallet($account_issuer, 'to'),
            'merchant_id'       =>  'TTM-00000002',
			'r-switch'	        =>	$r_switch,
			'amount'	        =>	$amount,
            'transacted_amount' =>  $transacted_amount,
			'transaction_id'	=> 	$id,
			'desc'		        => 	$desc,
			'account_number'    =>  $recipient,
			'account_issuer'	=>	$account_issuer,
			'exp_month'	        =>	$expMonth,
			'exp_year'	        =>	$expYear,
			'cvv'		        =>	$cvv,
			'pin'		        =>	$pin,
			'3d_response_url'	=>	$url
		];

		return $this->curlRequest(json_encode(self::setToAccountNumber($request, $number)));
		
	}

	private function debit( $mode, $number, $amount, $id, $desc, $expMonth = null, $expYear = null, $pin = null, $cvv = null, $url = null, $ref = null )
	{
	    $r_switch   = self::getRswitch($mode);
		$request    = [
			'processing_code'	=>	'00'.self::isMobileWallet($r_switch, 'from').'00',
            'merchant_id'       =>  'TTM-00000002',
			'r-switch'		    =>	$r_switch,
			'amount'	        =>	$amount,
			'transaction_id'	=> 	$id,
			'desc'		        => 	$desc,
			'exp_month'	        =>	$expMonth,
			'exp_year'	        =>	$expYear,
			'cvv'		        =>	$cvv,
			'pin'		        =>	$pin,
			'ref'		        =>	$ref,
			'3d_url_response'	=>	$url
		];

		if ($request['processing_code'] === '000200'){
		    unset($request['3d_url_response']);
        }

		return $this->curlRequest(json_encode(self::setToAccountNumber($request, $number)));
	}

    public static function getRswitch($mode)
    {
        $_mode = strtolower($mode);
        $all = ['mtn' => 'MTN', 'airtel' => 'ATL', 'tigo' => 'TGO', 'mastercard' => 'MAS', 'visa' => 'VIS', 'vodafone' => 'VDF'];
        if (!in_array($_mode, $all)){
            return [
                'status' => 'bad request',
                'code' => 999,
                'reason' => 'unknown r-switch'
            ];
        }
        return $all[$_mode];
	}

    public static function isMobileWallet($r_switch, $type)
    {
        if ($type === 'from'){
            return (in_array($r_switch, $all = ['MTN', 'ATL', 'TGO', 'VDF']))? '02' : '00';
        } elseif ($type === 'to'){
            return (in_array($r_switch, $all = ['MTN', 'ATL', 'TGO', 'VDF']))? '10' : '00';
        }

	}

    private static function setToAccountNumber($request, $number)
    {
        if (in_array($request['r-switch'], ['MTN', 'ATL', 'TGO', 'VDF'])){
            $request['subscriber_number']   =   $number;
            unset($request['cvv']); unset($request['exp_month']); unset($request['exp_year']); unset($request['3d_response_url']); unset($request['ref']); unset($request['pin']);
        } else {
            $request['pan']   =   $number;
        }
        return $request;
	}

	private function curlRequest( $data )
	{
		$headers = [
			'Content-Type: application/json',
			'Authorization: Basic '.base64_encode('theteller:MTEzMzM2ODQ1N3RoZXRlbGxlckZyaS1GZWIgMTctMjAxNw==')
		];

		$curl = curl_init('https://api.theteller.net/v1.1/transaction/process');
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($curl, CURLOPT_POST, true);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
		curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

		return json_decode(curl_exec($curl), true);
	}

	public static function history($userKey)
	{
		return Transaction::where('userKey', $userKey)->with('service')->get();
	}


	// POS TRANSACTION FUNCTIONS
    public static function purchase(Array $transaction)
    {
        $headers = [
            'Content-Type: application/json',
            'Authorization: Basic '.base64_encode('theteller:MTEzMzM2ODQ1N3RoZXRlbGxlckZyaS1GZWIgMTctMjAxNw==')
        ];

        $curl = curl_init('45.79.187.66/v1.1/transaction/process');
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $transaction);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

        return json_decode(curl_exec($curl), true);
    }

    public static function getApiDetailsUsingMerchantId(String $merchant_id)
    {

    }

    public static function alphaID( $in, $to_num = false, $pad_up = false, $pass_key = null )
    {
        $out      =  '';
        $index    =  'abcdefghijklmnopqrstuvwxyz0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $base     =  strlen( $index );

        if ( $pass_key !== null )
        {
            // Although this function's purpose is to just make the
            // ID short - and not so much secure,
            // with this patch by Simon Franz (http://blog.snaky.org/)
            // you can optionally supply a password to make it harder
            // to calculate the corresponding numeric ID

            for ($n = 0; $n < strlen($index); $n++)
            {
                $i[] = substr($index, $n, 1);
            }

            $pass_hash = hash('sha256',$pass_key);
            $pass_hash = (strlen($pass_hash) < strlen($index) ? hash('sha512', $pass_key) : $pass_hash);

            for ($n = 0; $n < strlen($index); $n++)
            {
                $p[] =  substr($pass_hash, $n, 1);
            }

            array_multisort($p, SORT_DESC, $i);
            $index = implode($i);
        }

        if ($to_num)
        {
            // Digital number  <<--  alphabet letter code
            $len = strlen($in) - 1;

            for ($t = $len; $t >= 0; $t--)
            {
                $bcp = bcpow($base, $len - $t);
                $out = $out + strpos($index, substr($in, $t, 1)) * $bcp;
            }

            if (is_numeric($pad_up)) // 0542349513
            {
                $pad_up--;
                if ($pad_up > 0)
                {
                    $out -= pow($base, $pad_up);
                }
            }
        }

        else
        {
            // Digital number  -->>  alphabet letter code
            if (is_numeric($pad_up))
            {
                $pad_up--;
                if ($pad_up > 0)
                {
                    $in += pow($base, $pad_up);
                }
            }

            for ($t = ($in != 0 ? floor(log($in, $base)) : 0); $t >= 0; $t--)
            {
                $bcp = bcpow($base, $t);
                $a   = floor($in / $bcp) % $base;
                $out = $out . substr($index, $a, 1);
                $in  = $in - ($a * $bcp);
            }
        }
        return substr($out, 0, 12);
    }

    public static function randomNum()
    {
        $number = "";
        for( $i = 0; $i < 12; $i++ )
        {
            $min = ($i == 0) ? 1:0;
            $number .= mt_rand($min,9);
        }
        return $number.gmdate( "Y" ).time();
    }

    // Generate transaction rrn code
    public static function rrn()
    {
        $number = "";
        for( $i = 0; $i < 12; $i++ )
        {
            $min = ( $i == 0 ) ? 1:0;
            $number .= mt_rand( $min, 9 );
        }
        return $number;
    }
}