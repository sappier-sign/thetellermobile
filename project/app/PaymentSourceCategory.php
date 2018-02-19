<?php
/**
 * Created by PhpStorm.
 * User: MEST
 * Date: 5/10/2017
 * Time: 10:44 AM
 */

namespace App;


use Illuminate\Database\Eloquent\Model;

class PaymentSourceCategory extends Model
{
	protected $table 		= 'tlr_payment_source_category';
	protected $primaryKey 	= 'paymentSourceCatKey';
	public $incrementing	= false;

	public function paymentSources()
	{
		return $this->hasMany(PaymentSource::class, 'paymentSourceCatKey');
	}

	public static function getPaymentSource($id = null)
	{
		$paymentSources = (is_null($id))? PaymentSourceCategory::with('paymentSources')->get() : PaymentSourceCategory::where('paymentSourceCatKey', $id)->with('paymentSources')->get();
		foreach ( $paymentSources->toArray() as $paymentSource ) {
			foreach ( $paymentSource['payment_sources'] as $source ) {
				$source['paymentSourceLogo'] = '45.56.99.27/'.$source['paymentSourceLogo'];
			}
		}
		return $paymentSources;
	}
}