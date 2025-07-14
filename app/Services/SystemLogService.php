<?php

namespace App\Services;

use Request;
use App\Models\{SystemLog};
use Illuminate\Support\Facades\{Hash, Storage, Auth};
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Route;

class SystemLogService
{
    static public function userModule($model, $deleted = false): SystemLog
    {
        $sessionUser = loggedUser();

        //$profile = $model->roles()->first()->getOriginal()->name;
        //dd($profile);
        $action = 'created';
        $newRequest = $model;
        if (!$model->wasRecentlyCreated) {
            $action = 'updated';
            $newRequest = [];
            if ($model->wasChanged("password")) {
                $newRequest['password'] = '******';
            }
            foreach ($model->toArray() as $field => $value) {
                if ($model->wasChanged($field) && $field != "updated_at" && $field != "created_at") {
                    $newRequest[$field] = $value;
                }
            }
        }
        $data = [
            "user_id" => (isset($sessionUser->id)) ? $sessionUser->id : 0,
            "name" => (isset($sessionUser->name)) ? $sessionUser->name : "",
            "email" => (isset($sessionUser->email)) ? $sessionUser->email : "",
            "profile" => (isset($sessionUser->id)) ? $sessionUser->roles()->first()->name : "",
            "module" => "Usuários",
            "action" => ($deleted) ? "deleted" : $action,
            "action_model" => $model->getTable(),
            "action_id" => $model->id,
            "old_request" => json_encode($model->getOriginal()),
            "route" => json_encode(Route::current()),
            "ip_address" => Request::getClientIp(true)
        ];
        if (!$deleted) {
            $data['new_request'] = json_encode($newRequest);
        }
        return SystemLog::create($data);
    }
}
