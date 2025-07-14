<?php

namespace App\Observers;

use App\Services\{SystemLogService};

class LogUserObserver
{
    //public $afterCommit = true;

    public function saved($model)
    {
        SystemLogService::userModule($model);
    }

    public function deleted($model)
    {
        SystemLogService::userModule($model, true);
    }
}
