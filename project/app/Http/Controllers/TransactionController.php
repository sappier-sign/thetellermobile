<?php
namespace App\Http\Controllers;
use App\Service;
use App\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TransactionController extends Controller
{

    public function handle( Request $request, $action )
    {
        if (!$request->header('User-Token')){
            return [
                'code'  =>  900,
                'status'    =>  'error',
                'description'   =>  'User-Token field is not present in headers'
            ];
        }

        if (in_array($action, ['debit', 'transfer'])) {
            $transaction                            = $request->all();
            $serviceName                            = Service::find($request->input('serviceKey'))->first()->serviceName;
            $transaction['transactionDesc']         = $serviceName . ' => theTellerApp ' . $request->header('Platform') . ' => ' . $request->input('transactionSRN');
            $transaction['userKey']                 = $request->header('User-Token');
            $transaction['transactionExtraData']    = $request->header('Platform','mobile');
            $transaction['transactionStatus']       = 0;
            $transaction['transactionDate']         = date('Y-m-d');
            $transaction['transactionTime']         = date('H:i:s');
            $transaction['transactionKey']          = time().'00';
            $transaction['transactionRRN']          = Transaction::rrn();
            $transaction['expMonth']                = $request->input('exp_month', null);
            $transaction['expYear']                 = $request->input('exp_year', null);
            $transaction['pan']                     = $request->input('pan', null);
            $transaction['cvv']                     = $request->input('cvv', null);
            $transaction['pin']                     = $request->input('pin', null);
            $transaction['url']                     = $request->input('3d_url_response', null);
            $transaction['wallet_id']               = $request->input('wallet_id');

            return Transaction::performTransaction($transaction);
        }
    }

    public function getUserHistory(Request $request)
    {
        return Transaction::history($request->header('User-Token'));
	}
}