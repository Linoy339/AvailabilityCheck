<?php
/**
 * @file   ProductARepository.php
 * @author Linoy
 * @date   January, 2021
 * @brief  Products repo
 *
 */
namespace App\Repositories;

use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductARepository
{
    /**
      * get all products based on the rules of class
      *
      * @return array $products
      */
    public function all()
    {
        $methods = get_class_methods($this);
        $products=[];
        foreach ($methods as $key => $value) {
            if (Str::startsWith($value, 'fetchRule')) {
                $products[] = $this->$value();
            }
        }
     
        return $products;
    }
    
    
    /**
      * get all products based on rule
      *
      * @return array $products
      */
    private function fetchRule_One()
    {
        $products['ruleDownloadSpeedGreaterThan100'] =    DB::table('products')->select(['id','name','download_speed','upload_speed','is_fibre'])
      ->where('download_speed', '>', 100)->get()->toArray();

        return $products;
    }

     /**
      * get all products based on rule
      *
      * @return array $products
      */
    private function fetchRule_Two()
    {
        $products['ruleIsFibre'] =    DB::table('products')->select(['id','name','download_speed','upload_speed','is_fibre'])
      ->where('is_fibre', '=', 1)->get()->toArray();

        return $products;
    }
    
}
