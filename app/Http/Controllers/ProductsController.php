<?php
/**
 * @file   ProductsController.php
 * @author Linoy
 * @date   January, 2021
 * @brief  Products List
 *
 */
namespace App\Http\Controllers;

use App\Repositories\ProductARepository;
use App\Repositories\ProductBRepository;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class ProductsController extends BaseController
{
    /**
    * Create a new controller instance.
    *
    * @param ProductARepository
    * @param ProductBRepository
    */
    public function __construct(ProductARepository $ProductARepository, ProductBRepository $ProductBRepository)
    {
        $this->products = $this->prepareProducts(array_merge($ProductARepository->all(), $ProductBRepository->all()));
    }

    /**
     * get all products based on rule
     *
     */
    public function products(Request $request)
    {
        return view('products')->with(['products'=>$this->products]);
    }

    /**
    * Prepare products
    *
    * @return array $products
    */
    public function prepareProducts($products)
    {
        $newProducts=[];
        $keys=[];
     
        foreach ($products as $key => $value) {
            foreach ($value as $keyI => $valueI) {
                $keys[]=$keyI;
            
                for ($i=0; $i <count($valueI) ; $i++) {
                    $valueI[$i]->$keyI=1;
                  
                    $newProducts[]=$valueI[$i];
                }
            }
        }
        $arrProducts = [];
        if (!empty($newProducts)) {
            foreach ($keys as $keyK => $valueK) {
                foreach ($newProducts as $key=>$value) {
                    if (array_key_exists($value->name, $arrProducts)) {
                        if (!array_key_exists($valueK, $arrProducts[$value->name])) {
                            if (isset($value->$valueK)) {
                                $arrProducts[$value->name]->$valueK=1;
                            }
                        }
                    } else {
                        $arrProducts[$value->name]=$value;
                        $arrProducts[$value->name]->styles=[];
                    }
                }
            }
        
            foreach ($arrProducts as $key => $value) {
                foreach ($keys as $keyK => $valueK) {
                    if (array_key_exists($valueK, $value)) {
                        array_push($arrProducts[$key]->styles, $this->generateHtml($valueK));
                    }
                }
            }
        }
        return $arrProducts;
    }


    /**
         * generate html for each rule
         *
         * @return string $rule
         */
    public function generateHtml($rule)
    {
        switch ($rule) {
             case 'ruleDownloadSpeedGreaterThan100':
             return '<label>Download speed greater than 100</label><input type="checkbox" name="ruleDownloadSpeedGreaterThan100" checked="checked"/>';
            
         
            break;
            case 'ruleIsFibre':
                return '<label>fibre</label><input type="checkbox" name="ruleIsFibre" checked="checked"/>';
            break;
          case 'ruleUploadSpeedGreaterThan100':
             return '<label>Upload speed greater than 100</label><input type="checkbox" name="ruleUploadSpeedGreaterThan100" checked="checked"/>';
            break;
           
          default:
            
            break;
        }
    }
}
