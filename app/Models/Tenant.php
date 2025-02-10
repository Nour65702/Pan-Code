<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Stancl\Tenancy\Contracts\TenantWithDatabase;
use Stancl\Tenancy\Database\Concerns\HasDatabase;
use Stancl\Tenancy\Database\Concerns\HasDomains;
use Stancl\Tenancy\Database\Concerns\TenantRun;
use Stancl\Tenancy\Database\Models\Domain;
use Stancl\Tenancy\Database\Models\Tenant as ModelsTenant;

class Tenant extends ModelsTenant implements TenantWithDatabase
{
    use HasFactory, HasDatabase, TenantRun, HasDomains;

    protected $fillable = ['name', 'owner_id', 'domain'];

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function teams()
    {
        return $this->hasMany(Team::class);
    }

    public function domains()
    {
        return $this->hasMany(Domain::class);
    }

    public function getTenantKeyName(): string
    {
        return 'id';
    }

    public function getTenantKey()
    {
        return $this->getAttribute($this->getTenantKeyName());
    }

    public function setInternal(string $key, $value): void
    {
        $this->$key = $value;
    }

    public function getInternal(string $key, $default = null)
    {
        return $this->$key ?? $default;
    }
}
