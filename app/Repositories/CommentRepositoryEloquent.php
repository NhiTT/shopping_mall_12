<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\CommentRepository;
use App\Models\Comment;
use App\Validators\CommentValidator;

/**
 * Class CommentRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class CommentRepositoryEloquent extends BaseRepository implements CommentRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Comment::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    public function __construct()
    {
        $this->model = new Comment;
    }

    public function getAll($p)
    {
        $query = $this->model;
        $query = $query->select('comments.id', 'user_id', 'comment_id', 'parent_id', 'content', 'title', 'last_name', 'first_name', 'comments.created_at', 'comment_type', 'comments.status')
        ->join('users', 'comments.user_id', '=', 'users.id')
        ->join('products', 'comments.comment_id', '=', 'products.id')
        ->where('comments.comment_id', '=', $p)
        ->orderBy('comments.created_at', 'desc');

        return $query->paginate(10);
    }

    public function getCommentProduct($p)
    {
        $query = $this->model;
        $query = $query->select('comments.id', 'user_id', 'comment_id', 'parent_id', 'content', 'title', 'last_name', 'first_name', 'comments.created_at', 'comment_type', 'comments.status')
        ->join('users', 'comments.user_id', '=', 'users.id')
        ->join('products', 'comments.comment_id', '=', 'products.id')
        ->where('comments.comment_id', '=', $p)
        ->where('comments.comment_type', '=', 1)
        ->orderBy('comments.created_at', 'desc');

        return $query->paginate(5);
    }

    public function getCommentQuestion($p)
    {
        $query = $this->model;
        $query = $query->select('comments.id', 'user_id', 'comment_id', 'parent_id', 'content', 'title', 'last_name', 'first_name', 'comments.created_at', 'comment_type', 'comments.status')
        ->join('users', 'comments.user_id', '=', 'users.id')
        ->join('products', 'comments.comment_id', '=', 'products.id')
        ->where('comments.comment_id', '=', $p)
        ->where('comments.comment_type', '!=', 1)
        ->orderBy('comments.created_at', 'desc');

        return $query->paginate(10);
    }
}
