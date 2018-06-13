<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\ProductRepository;
use App\Validators\ProductValidator;
use App\Models\Product;

/**
 * Class ProductRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class ProductRepositoryEloquent extends BaseRepository implements ProductRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Product::class;
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
        $this->model = new Product;
    }

    public function getProductByCategoryId($param, $id)
    {
        $query = $this->model;
        $query = $query->select('*', 'products.id as pid', 'products.name as pname', 'products.slug as pslug')
        ->join('categories', 'categories.id', '=', 'products.category_id')
        // ->where('categories.status', 1)
        ->where('category_id', $id)
        ->orwhere('parent_id', $id)
        ->orderBy('products.created_at', 'desc');

        return $query->paginate($param);
    }
}
