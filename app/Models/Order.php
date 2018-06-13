<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\PaymentMethod;

class Order extends Model
{
    /**
     * fill into table orders
     * @var array
     */
    protected $fillable = [
        'user_id',
        'payment_method_id',
        'amount',
        'phone',
        'name',
        'address',
        'zipcode',
        'status',
    ];

    public function paymentMethod()
    {
        return $this->hasOne('PaymentMethod');
    }

    public function genPayment()
    {
        $payment_method_id = self::find($this->payment_method_id);
        if (!$payment_method_id) {
            return;
        }

        return $payment_method_id->payment;
    }
}
