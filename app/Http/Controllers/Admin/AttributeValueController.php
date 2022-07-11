<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use App\Models\AttributeValue;
use App\Contracts\AttributeContract;

class AttributeValueController extends BaseController
{
    protected $attributeRepository;

    public function __construct(AttributeContract $attributeRepository)
    {
        $this->attributeRepository = $attributeRepository;
    }

    public function getValues($id, $edit_id = Null)
    {
        $attribute = $this->attributeRepository->findAttributeById($id);
        
        // $editDataById = [];
        if ($edit_id != Null) {
            $editDataById = AttributeValue::findOrFail($edit_id);
            $editDataById=$editDataById->getattributes();
        }else{
            $editDataById = array('id' => Null,'price' => Null,'value' => Null,'id' => Null,);
        }
        
        $this->setPageTitle('Attributesvalue', 'List of all attributes values');
        $attribute_arr  = $attribute->values;
        return view('admin.attributes.includes.AddAttributeValue', compact('attribute_arr', 'editDataById'));
    }


    public function addValues(Request $request)
    {
        $value = new AttributeValue();
        $value->attribute_id = $request->input('attribute_id');
        $value->value = $request->input('value');
        $value->price = $request->input('price');
       $returnData =  $value->save();
      
        if (!$returnData) {
            return $this->responseRedirectBack('Error occurred while updating attribute.', 'error', true, true);
        }
        return $this->responseRedirectBack('Attribute updated successfully', 'success', false, false);
    }


    public function editValues($id)
    {
        $attribute = $this->attributeRepository->findAttributeById($id);
        $this->setPageTitle('Attributes', 'Edit Attribute : ' . $attribute->name);
        return view('admin.attributes.includes.editValues', compact('attribute'));
    }

    public function updateValues(Request $request)
    {
        $attribute_id = $request->input('attribute_id');
        $attributeValue = AttributeValue::findOrFail($request->input('editid'));
        $attributeValue->attribute_id = $attribute_id;
        $attributeValue->value = $request->input('value');
        $attributeValue->price = $request->input('price');
        $attributeValue->save();
        return redirect("admin/attributes/getvalues/$attribute_id");
    }


    public function deleteValues($id, $attribute_id)
    {
        $attributeValue = AttributeValue::findOrFail($id);
        $attributeValue->delete();
        return redirect("admin/attributes/getvalues/$attribute_id");
    }
}
