<?php namespace App\Http\Facades\Repository;

use Illuminate\Support\Facades\Facade;

/**
 * Class ProductFacade
 *
 * @package App\Http\Facades\Repository
 */
class ProductFacade extends Facade
{

    /**
     * @return string
     */
    public static function getFacadeAccessor()
    {
        return 'product';
    }
}