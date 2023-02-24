<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContractStatusLog extends Model
{
    use HasFactory;

    public $table = 'contract_status_log';

    public $fillable = [
        'contract_id',
        'action_taked_by',
        'from',
        'to'
    ];

    public function contract()
    {
        return $this->belongsTo(Contract::class, 'contract_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'action_taked_by');
    }
}
