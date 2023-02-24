<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContractMilestone extends Model
{
    use HasFactory;
    const PENDING = 'pending';

    public $fillable = [
        'name',
        'due_to',
        'budget',
        'status'
    ];

    public $dates = [
      'due_to'
    ];

    public function contract()
    {
        return $this->belongsTo(Contract::class, 'contract_id');
    }
}
