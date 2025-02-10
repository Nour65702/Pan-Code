<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeamInvitation extends Model
{
    use HasFactory;

    protected $fillable = ['email', 'team_id', 'token', 'tenant_id'];

    public function team()
    {
        return $this->belongsTo(Team::class);
    }
}
