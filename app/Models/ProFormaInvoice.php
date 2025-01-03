<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProFormaInvoice extends Model
{
    use HasFactory;

    protected $fillable = ['name','mobile','email','address','invoice_number','date','total','grand_total','advance','due','language_id','currency_id','billing_address','bank_detail','remarks','tax_amount','remarks_enabled','gst_enabled','show_system_gen'];

    function proFormaInvoiceDetails()
    {
    	return $this->hasMany(ProFormaInvoiceDetail::class, 'pro_forma_invoice_id', 'id');
    }

     public function language()
    {
        return $this->belongsTo(Language::class, 'language_id', 'id');
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class, 'currency_id', 'id');
    }

    public function billingAddress()
    {
        return $this->belongsTo(Address::class, 'billing_address', 'id');
    }

    public function bankDetail()
    {
        return $this->belongsTo(BankDetail::class, 'bank_detail', 'id');
    }
}
