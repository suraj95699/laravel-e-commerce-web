<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;;

use Illuminate\Http\Request;
use App\Contracts\AttributeContract;
use App\Models\ProductAttribute;

class ProductAttributeController extends BaseController
{


    protected $attributeRepository;

    public function __construct(
        AttributeContract $attributeRepository
    ) {
        $this->attributeRepository = $attributeRepository;
    }

    public function getAttibuteOptionsJson()
    {
        $attribute = $this->attributeRepository->findAttributeById($_GET["id"]);
        $attribute_arr  = $attribute->values;
        return response()->json($attribute_arr);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function addAttribute(Request $request)
    {
       
        $reqData = $request->except('_token');
        $productAttribute = ProductAttribute::create($reqData);
        if ($productAttribute) {
            return $this->responseRedirectBack('Product attribute added successfully.', 'success', false, false);
        } else {
            return response()->json(['message' => 'Something went wrong while submitting product attribute.']);
        }
    }


    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteAttribute($id)
    {
        $productAttribute = ProductAttribute::findOrFail($id);
        $productAttribute->delete();
        return $this->responseRedirectBack('Product attribute Deleted successfully.', 'success', false, false);
    }
}
