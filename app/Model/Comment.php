<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
    protected $table = 'comment';
    protected $guarded = [];
    protected $dates = ['deleted_at'];

    use SoftDeletes;

    public function articel_id()
    {
        return $this->belongsTo('App\Model\Articel', 'articel', 'id');
    }

    public function getUser()
    {
        return $this->belongsTo('App\Model\User', 'user', 'id');
    }

    public function changeShow($show)
    {
        $this->show = $show ? 1 : 0;
        $this->save();
    }

    public static function addComment(Articel $articel, $content, $niming, $user = null)
    {
        $comment = new self();
        $comment->articel = $articel->id;
        $comment->content = $content;
        $comment->user = $user;
        $comment->show = 1;
        $comment->zan = 0;
        $comment->niming = $niming;

        $comment->save();
        return $comment;
    }

    /**
     * 获取回复的用户
     */
    public function getReply()
    {
        return $this->belongsTo(Comment::class, 'reply', 'id');
    }
}
