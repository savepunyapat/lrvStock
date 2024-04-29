<?php

namespace App\Http\Controllers;

use App\Models\Model\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Throwable;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //print_r(config('global.global_var.pro_status')[0]);
        $products = Product::latest()->paginate(10);
        return view('backend.pages.products.index', compact('products'))->with('i', (request()->input('page', 1) - 1) * 10);
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
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        } else {
            $product_data = array(
                'product_name' => $request->product_name,
                'product_detail' => $request->product_detail,
                'product_barcode' => $request->product_barcode,
                'product_qty' => $request->product_qty,
                'product_price' => $request->product_price,
                'product_category' => $request->product_category,
                'product_status' => $request->product_status,
                'created_at' => NOW(),
                'updated_at' => NOW()
            );

            try {
                $image = request()->file('product_image');

                if (!empty($image)) {
                    $file_name = "product_" . time() . "." . $image->getClientOriginalExtension();
                    if ($image->getClientOriginalExtension() == "jpg" or $image->getClientOriginalExtension() == "png") {
                        $manager = new ImageManager(new Driver());
                        $imgWidth = 300;
                        $folderupload = "assets/images/products";
                        $path = $folderupload . "/" . $file_name;

                        // upload to folder products
                        $img = $manager->read($image->getRealPath());

                        if ($img->width() > $imgWidth) {
                            $img->resize($imgWidth, null, function ($constraint) {
                                $constraint->aspectRatio();
                            });
                        }

                        $img->save($path);
                        $product_data['product_image'] = $file_name;
                    } else {
                        return redirect()->route('products.create')->withErrors($validator)->withInput()->with('status', '<div class="alert alert-danger">ไฟล์ภาพไม่รองรับ อนุญาติเฉพาะ .jpg และ .png</div>');
                    }
                }
            } catch (Throwable $e) {
                print_r($e->getMessage());
                return false;
            }
            $status = Product::create($product_data);
            return redirect()->route('products.create')->with('success', 'เพิ่มข้อมูลสินค้าเรียบร้อยแล้ว');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return view('backend.pages.products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        return view('backend.pages.products.edit', compact('product'));
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
