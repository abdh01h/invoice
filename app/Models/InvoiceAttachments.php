<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class InvoiceAttachments extends Model
{
    use HasFactory;
    use LogsActivity;

    protected $guarded = [];

    // Logs Activity
    protected static $logName                 = 'Invoice Attachments Module';
    protected static $logUnguarded            = true;
    protected static $logOnlyDirty            = true;
    protected static $dontSubmitEmptyLogs     = true;

}
