<?php
/**
 * Created by PhpStorm.
 * User: MEST
 * Date: 5/10/2017
 * Time: 10:53 AM
 */

namespace App;
use Illuminate\Database\Eloquent\Model;

class PaymentSource extends Model
{
	protected $table 		= 'tlr_payment_sources';
	protected $primaryKey	= 'paymentSourceKey';
	public $incrementing	= false;

	public function paymentSourceCategory()
	{
		return $this->belongsTo(PaymentSourceCategory::class);
	}
}