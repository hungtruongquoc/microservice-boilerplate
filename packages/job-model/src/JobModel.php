<?php

namespace Hungtruong\JobModel;

use Illuminate\Database\Eloquent\Model;

class JobModel extends Model
{
    protected $table = "jobs";
    protected $fillable = ['submitter_id', 'processor_id', 'command', 'started_at', 'completed_at'];
    protected $appends = ['status'];
    // Build your next great package.
    public function resolveChildRouteBinding($childType, $value, $field)
    {
        // TODO: Implement resolveChildRouteBinding() method.
    }

    public function getStatusAttribute($value)
    {
        if (is_null($this->started_at)) {
            return 'Pending';
        }
        if (is_null($this->completed_at) && !is_null($this->started_at) && !is_nulli($this->processor_id)) {
            return 'In Progress';
        }
        return 'Unknown';
    }
}
