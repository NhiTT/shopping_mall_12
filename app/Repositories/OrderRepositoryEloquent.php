<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\OrderRepository;
use App\Entities\Order;
use App\Validators\OrderValidator;

/**
 * Class OrderRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class OrderRepositoryEloquent extends BaseRepository implements OrderRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Order::class;
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
        $this->model = new Order;
    }

    public function getAll($param)
    {
        $query = $this->model;
        $query = $query->select('*', 'orders.id as oid')
        ->join('users', 'users.id', '=', 'orders.user_id')
        ->orderBy('orders.created_at', 'desc');

        return $query->paginate($param);
    }
}
