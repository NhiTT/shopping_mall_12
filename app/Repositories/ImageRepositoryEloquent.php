<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\ImageRepository;
use App\Entities\Image;
use App\Validators\ImageValidator;

/**
 * Class ImageRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class ImageRepositoryEloquent extends BaseRepository implements ImageRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Image::class;
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
        $this->model = new Image;
    }

    public function getAll($param)
    {
        $query = $this->model;
        $query = $query->select('images.id', 'img_path', 'images.created_at', 'images.updated_at', 'products.name')
        ->join('product_attributes', 'product_attributes.id', '=', 'images.product_attributes_id')
        ->join('products', 'product_attributes.product_id', '=', 'products.id')
        ->orderBy('images.created_at', 'desc');

        return $query->paginate($param);
    }
}
