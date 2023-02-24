<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    use HasFactory;

    const PENDING = 'pending';
    const STARTED = 'started';
    const REJECTED = 'rejected';
    const FINISHED = 'finished';
    const ACCEPTED = 'accepted';
    const PARTIAL_ACCEPTED = 'partial_accepted';

    const STATASES = [
      self::PENDING => 'Under Review',
      self::STARTED => 'Contract Started',
      self::REJECTED => 'Contract Rejected',
      self::FINISHED => 'Contract Ended'
    ];

    const MESSAGES = [
      self::PENDING => 'Review Contract',
      self::STARTED => 'Contract Started',
      self::REJECTED => 'Contract Rejected',
      self::FINISHED => 'Contract Finalized'
    ];

    const COLORS = [
      self::PENDING => 'orange',
      self::STARTED => 'green',
      self::REJECTED => 'red',
      self::FINISHED => 'blue'
    ];


    public $fillable = [
        'task_id',
        'client_id',
        'specialist_id',
        'start_at',
        'end_at',
        'duration',
        'budget',
        'status'
    ];

    public $dates = [
      'start_at', 'end_at'
    ];

    public $appends = ['status_label', 'status_color', 'status_message'];

    public function specialist()
    {
        return $this->belongsTo(User::class, 'specialist_id');
    }

    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    public function milestones()
    {
        return $this->hasMany(ContractMilestone::class);
    }

    public function task()
    {
        return $this->belongsTo(Task::class, 'task_id');
    }

    public function participants()
    {
        return $this->belongsToMany(User::class, 'contract_participants', 'contract_id', 'user_id')->withPivot('status')->withTimestamps();
    }

    public function getStatusLabelAttribute()
    {
      return data_get(self::STATASES, $this->status, $this->status);
    }

    public function getStatusMessageAttribute()
    {
      return data_get(self::MESSAGES, $this->status, $this->status);
    }

    public function getStatusColorAttribute()
    {
      return data_get(self::COLORS, $this->status, $this->status);
    }

}
