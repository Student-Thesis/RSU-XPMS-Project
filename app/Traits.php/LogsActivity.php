<?php

namespace App\Traits;

use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

trait LogsActivity
{
    public static function bootLogsActivity(): void
    {
        static::created(function ($model) {
            $model->logActivity(
                'Created ' . class_basename($model),
                $model->getAttributes()
            );
        });

        static::updated(function ($model) {
            $model->logActivity(
                'Updated ' . class_basename($model),
                [
                    'old' => $model->getOriginal(),
                    'new' => $model->getChanges(),
                ]
            );
        });

        static::deleted(function ($model) {
            $model->logActivity('Deleted ' . class_basename($model));
        });
    }

    public function logActivity(string $action, array $changes = []): void
    {
        ActivityLog::create([
            'id'          => Str::uuid(),
            'user_id'     => Auth::id(),
            'action'      => $action,
            'model_type'  => get_class($this),
            'model_id'    => $this->id ?? null,
            'changes'     => $changes,
            'ip_address'  => request()->ip(),
            'user_agent'  => request()->userAgent(),
        ]);
    }
}
