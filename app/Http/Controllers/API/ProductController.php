<?php

namespace App\Http\Controllers\API;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    //NOTE:AMBIL DATA
    public function all(Request $request)
    {
        $id = $request->input('id');
        $limit = $request->input('limit', 6);
        $name = $request->input('name');
        $description = $request->input('description');
        $tags = $request->input('tags');
        $categories = $request->input('categories');
        $price_from = $request->input('price_from');
        $price_to = $request->input('price_to');


        if ($id) {
            $product = Product::with(['category', 'galleries'])->find($id); //Relasi

            //NOTE:CEK DATA ADA APA TIDAK
            if ($product) {
                return ResponseFormatter::success(
                    $product,
                    'Data product berhasil diambil'
                );
            } else {
                return ResponseFormatter::error(
                    null,
                    'Data product tidak ada',
                    404
                );
            }
        }
        //NOTE:MENGAMBIL DATA
        $product = Product::with(['catagories', 'galleries']);

        //NOTE:FILTERING DATA
        if ($name) {
            $product->where('name', 'like', '%' . $name . '%');
        }
        if ($description) {
            $product->where('description', 'like', '%' . $description . '%');
        }
        if ($tags) {
            $product->where('tags', 'like', '%' . $tags . '%');
        }
        if ($price_from) {
            $product->where('price', '>=', $price_from);
        }
        if ($price_to) {
            $product->where('name', '<=', $price_to);
        }
        if ($categories) {
            $product->where('catagories', $categories);
        }
        return ResponseFormatter::success(
            //*TODO : Pagination merupakan adalah sebuah fitur web yang digunakan untuk membatasi tampilan data agar tidak terlalu panjang dan  lebih rapi
            //*TODO :UNTUK MENGAMBIL DATA
            $product->paginate($limit),
            'Data product berhasil diambil'
        );
    }
}
