<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = [
        'customer_id',
        'bsn',
        'first_name',
        'last_name',
        'date_of_birth',
        'phone_number',
        'email',
        'tag',
        'address',
        'products',
        'ip_address',
        'iban',
        'last_invoice_date',
        'last_login_date_time',
        'is_fraudulent',
        'scan_id',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'last_invoice_date' => 'date',
        'last_login_date_time' => 'datetime',
    ];

    public function scan()
    {
        return $this->belongsTo(Scan::class);
    }
}
