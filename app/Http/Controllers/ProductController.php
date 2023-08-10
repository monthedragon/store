<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Database\QueryException;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\Console\Input\Input;

class ProductController extends Controller
{
    
    public function index(){
        
        if(request('name') || request('page')){
            //Cached the result of the search key
            $requestKey = request('name'). request('page');

            $products =  Cache::remember($requestKey, 10, function () {
                return Product::filterResult(request(['name']))->paginate(10);
            });

        }else{
            $products = Product::filterResult(request(['name']))->paginate(10);
        }

        return view('product.index', ['products' => $products , 'name' => request('name')??'']);
    }

    public function create(){
        return view('product.create');
    }

    //storing the products
    //TODO add thumbnail
    public function store(Request $request){

        $attributes = $request->validate([
            'name' => ['required', 'min:5', 'unique:products,name'],
            'price' => ['required', 'numeric'],
            'description' => ['required', 'min:20'],
            // 'thumbnail' => 'required|file|mimes:jpg,png,pdf|max:2048'
        ]);

        $product = Product::create($attributes);

        return redirect('/product/')->with(['msg' => 'New Product Successfully created']);
    }

    public function edit(Product $product){
        return view('product.edit', ['product' => $product]);
    }

    public function update(Product $product, Request $request){

        $attributes = $request->validate([
            'name' => ['required', 'min:5', Rule::unique('products', 'name')->ignore($product->id)],
            'price' => ['required', 'numeric'],
            'description' => ['required', 'min:20'],
            // 'thumbnail' => 'required|file|mimes:jpg,png,pdf|max:2048'
        ]);

        $product->fill($attributes);
        $product->save();

        return redirect('/product/')->with(['msg' => 'Product Successfully updated']);

    }

    public function destroy(Product $product){
        try {
            // Attempt to delete the record
            $product->delete();
            
            return back()->with('msg', 'Product Successully deleted.' );
        } catch (QueryException $e) {
            return back()->with('err_msg', 'Cannot delete the record due to related data.' );
        }
    }
}
