<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

  
    protected $fillable = [
        'name', 'email', 'password',
    ];

    
    protected $hidden = [
        'password', 'remember_token',
    ];


public function microposts()
    {
        return $this->hasMany(Micropost::class);
    }
    
     public function followings()
    {
        return $this->belongsToMany(User::class, 'user_follow', 'user_id', 'follow_id')->withTimestamps();
    }

    public function followers()
    {
        return $this->belongsToMany(User::class, 'user_follow', 'follow_id', 'user_id')->withTimestamps();
    }
    
    public function follow($userId)
    {
    $exist = $this->is_following($userId);
    
    $its_me = $this->id == $userId;

    if ($exist || $its_me) {

        return false;
    } else {
       
        $this->followings()->attach($userId);
        return true;
    }
    }

public function unfollow($userId)
    {
    
    $exist = $this->is_following($userId);
    
    $its_me = $this->id == $userId;


    if ($exist && !$its_me) {
       
        $this->followings()->detach($userId);
        return true;
    } else {
        
        return false;
    }
    }

    public function is_following($userId) {
    return $this->followings()->where('follow_id', $userId)->exists();
    }
 
  public function feed_microposts()
    {
        $follow_user_ids = $this->followings()-> pluck('users.id')->toArray();
        $follow_user_ids[] = $this->id;
        return Micropost::whereIn('user_id', $follow_user_ids);
    }
    
    public function fab()
    {
        return $this->belongsToMany(Micropost::class, 'favourites', 'user_id', 'favourite_id')->withTimestamps();
    }
    
    public function favourites($micropostId)
    {
    $exist = $this->is_favourite($micropostId);
    

    if ($exist) {

        return false;
    } else {
       
        $this->fab()->attach($micropostId);
        return true;
    }
    }
    
    public function unfavourites($micropostId)
    {
    $exist = $this->is_favourite($micropostId);
    
    if ($exist) {
       
        $this->fab()->detach($micropostId);
        return true;
    } else {
        
        return false;
    }
    }
    
    public function is_favourite($micropostId) {
    return $this->fab()->where('favourite_id', $micropostId)->exists();
    }
    
}
