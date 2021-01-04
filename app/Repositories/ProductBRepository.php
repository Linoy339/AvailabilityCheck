<?php
/**
 * @file   ProductBRepository.php
 * @author Linoy
 * @date   January, 2021
 * @brief  Products repo
 *
 */
 namespace App\Repositories;

use DB;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Exception;

class ProductBRepository
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
        $products['ruleUploadSpeedGreaterThan100'] =    DB::table('products')->select(['id','name','download_speed','upload_speed','is_fibre'])
      ->where('upload_speed', '<', 100)->get()->toArray();
      
        return $products;
    }
}
