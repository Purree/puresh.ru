<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RestrictedIp extends Model
{
    use HasFactory;

    public $timestamps = false;

    public static function banIP(string $ip): void
    {
        $restrictedIp = new RestrictedIp();
        $restrictedIp->ip = $ip;
        $restrictedIp->save();
    }

    public function unban()
    {
        $this->delete();
    }
}
