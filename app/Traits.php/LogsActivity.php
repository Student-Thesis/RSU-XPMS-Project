<?php

// app/Traits/LogsActivity.php
namespace App\Traits;

use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

trait LogsActivity
{
    /**
     * This will be called automatically by Eloquent
     * when the model boots.
     */
    public static function bootLogsActivity(): void
    {
        // 🔹 CREATE
        static::created(function ($model) {
            $model->logActivity(
                'Created ' . class_basename($model),
                $model->getAttributes()
            );
        });

        // 🔹 UPDATE
        static::updated(function ($model) {
            // getChanges() = only changed fields
            // getOriginal() = values before update
            $model->logActivity(
                'Updated ' . class_basename($model),
                [
                    'old' => $model->getOriginal(),
                    'new' => $model->getChanges(),
                ]
            );
        });

        // 🔹 DELETE
        static::deleted(function ($model) {
            $model->logActivity(
                'Deleted ' . class_basename($model)
            );
        });
    }

    /**
     * Can still be called manually from controller/service
     */
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
