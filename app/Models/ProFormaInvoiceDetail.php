<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProFormaInvoiceDetail extends Model
{
    use HasFactory;
    protected $fillable = ['pro_forma_invoice_id','description','pax','price','total'];
}
