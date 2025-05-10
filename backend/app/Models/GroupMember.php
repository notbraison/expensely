<?php
/* In the GroupMember model, the group() method defines an inverse one-to-many relationship with the Group model,
     and the user() method defines a belongsTo relationship with the User model. */

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GroupMember extends Model
{
    /** @use HasFactory<\Database\Factories\GroupMembersFactory> */
    use HasFactory;

    protected $fillable = ['group_id', 'user_id', 'role'];

    /**
     * Get the group that this member belongs to.
     */
    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    /**
     * Get the user associated with this group member.
     */
    public function user()
    {
        return $this->belongsTo(User::class); // Assuming you have a 'users' table
    }
}
