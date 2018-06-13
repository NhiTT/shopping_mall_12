<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\CouponProgramRepository;
use App\Models\CouponProgram;
use App\Validators\CouponProgramValidator;

/**
 * Class CouponProgramRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class CouponProgramRepositoryEloquent extends BaseRepository implements CouponProgramRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return CouponProgram::class;
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
        $this->model = new CouponProgram;
    }

    public function getCoupon($limit)
    {
        $query = $this->model;
        $query = $query->select('*', 'coupons.id as cid', 'products.id as pid')
        ->join('coupons', 'coupons.id', '=', 'coupon_programs.coupon_id')
        ->join('products', 'products.id', '=', 'coupon_programs.product_id')
        ->orderBy('coupons.created_at', 'desc');

        return $query->paginate($limit);
    }

    public function checkCouponProgram($code, $p)
    {
        $limit = 100;
        $query = $this->model;
        $query = $query->join('coupons', 'coupons.id', '=', 'coupon_programs.coupon_id')
        ->join('products', 'products.id', '=', 'coupon_programs.product_id')
        ->where('coupons.code', '=', $code)
        ->where('coupon_programs.product_id', '=', $p);

        return $query->paginate($limit);
    }
}
