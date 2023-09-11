<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'username', 'password', 'role_id', 'department_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Get the user's full name.
     *
     * @return string
     */
    public function getFullNameAttribute()
    {
        if (is_null($this->name)) {
            return "{$this->name}";
        }

        return "{$this->name}";
    }

    /**
     * Set the user's password.
     *
     * @param string $value
     * @return void
     */
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }

    public function files()
    {
        return $this->hasMany(Files::class, 'id', 'user_id');
    }

    public function role()
    {
        return $this->hasOne(Role::class, 'id', 'role_id');
    }

    public function department()
    {
        return $this->hasOne(Department::class, 'id', 'department_id');
    }

    public function isSuperAdmin()
    {
        if($this->role_id == 1) return true;
        
        return false;
    }

    public function isAdmin()
    {
        if($this->role_id == 2) return true;

        return false;
    }

    public function getUsersWithRoles(): Collection
    {
        return $this->with('role')->get();
    }

    public function getUsersWithDepartments(): Collection
    {
        return $this->with('department')->get();
    }

    public function getUsersWithRoleAndDepartment(): Collection
    {
        return $this->with(['role', 'department'])->get();
    }

    public function addNewUser(Array $data)
    {
        return $this->create([
            'name' => $data['name'],
            'username' => $data['username'],
            'password' => $data['password'],
            'role_id' => $data['role'],
            'department_id' => $data['department']
        ]);
    }

    public function updateUser(Array $data)
    {
        $this->name = $data['name'];
        $this->username = $data['username'];
        $this->role_id = $data['role'];
        $this->department_id = $data['department'];

        return $this->save();
    }

}
