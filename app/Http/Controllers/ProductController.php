<?php

namespace App\Http\Controllers;

use App\Models\Model\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\UploadedFile;
class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::latest()->paginate(10);
        return view('backend.pages.products.index',compact('products'))->with('i', (request()->input('page', 1) - 1) * 10) ;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.pages.products.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        echo "<pre>";
        print_r($request->all());
        echo "</pre>";

        $rules = [
            'product_name' => 'required',
            'product_barcode' => 'required|integer|digits:13|unique:products',
            'product_qty' => 'required',
            'product_price' => 'required',
            'product_category' => 'required'
        ];
        $messages = [
            'required' => 'ฟิลด์ :attribute นี้จำเป็น',
            'integer' => 'ฟิลด์นี้ต้องเป็นตัวเลขเท่านั้น',
            'digits' => 'ฟิลด์ :attribute ต้องเป็นตัวเลขความยาว :digits หลัก',
            'unique' => 'รายการนี้มีอยู่แล้วในตาราง (ห้ามซ้ำ)'
        ];
        $validator = Validator::make($request->all(), $rules,$messages);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }else {
            $productData = $request->all();
            if ($request->hasFile('product_image')) {
                $image = $request->file('product_image');
                $imageName = uniqid() . '.' . $image->getClientOriginalExtension(); // Generate unique name
                $image->storeAs('products', $imageName); // Move to 'products' folder
                $productData['product_image'] = $imageName; // Update product data with image name
            }else {
                $productData['product_image'] = 'no-image.jpg'; // Default image
            }
            Product::create($productData);
            return redirect()->route('products.create')->with('success', 'เพิ่มข้อมูลสินค้าเรียบร้อยแล้ว');
        }
        
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        return view('backend.pages.products.edit',compact('product'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $product->update($request->all());
        return redirect()->route('products.index')->with('success', 'แก้ไขข้อมูลสินค้าเรียบร้อยแล้ว');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('products.index')->with('success', 'ลบข้อมูลสินค้าเรียบร้อยแล้ว');    
    }
}
