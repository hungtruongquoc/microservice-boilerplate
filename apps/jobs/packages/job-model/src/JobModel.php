<?php

namespace Hungtruong\JobModel;

use Illuminate\Database\Eloquent\Model;

class JobModel extends Model
{
    protected $table = "jobs";
    protected $fillable = ['submitter_id', 'processor_id', 'command', 'started_at', 'completed_at'];
    // Build your next great package.
    public function resolveChildRouteBinding($childType, $value, $field)
    {
        // TODO: Implement resolveChildRouteBinding() method.
    }
}
