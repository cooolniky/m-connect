<?php namespace App\Http\Facades\Repository;

use Illuminate\Support\Facades\Facade;

/**
 * Class ShopFacade
 *
 * @package App\Http\Facades\Repository
 */
class ShopFacade extends Facade
{

    /**
     * @return string
     */
    public static function getFacadeAccessor()
    {
        return 'shop';
    }
}