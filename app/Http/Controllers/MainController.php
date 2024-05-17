<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use App\Models\Orders;
use App\Models\Products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MainController extends Controller
{

    private $products;

    public function __construct()
    {
        $this->products = new Products;
    }

    public function homepage()
    {
        $categories = Categories::all();

        if (auth()->user()->type == 1) {
            return view('userpages.admin.homepage', compact("categories"));
        } else {
            return view('userpages.homepage', compact("categories"));
        }
    }

    public function orders()
    {
        $orders = Orders::where('userID', auth()->user()->id)
            ->join('products', 'orders.productID', '=', 'products.productID')
            ->join('categories', 'products.categoryID', '=', 'categories.categoryID')
            ->select('orders.*', 'products.name as name', 'products.description as description', 'categories.categoryID as categoryID')
            ->where('status', 'Pending')
            ->get();

        return view('userpages.order', compact("orders"));
    }

    public function products()
    {
        $products = Products::all();

        return response(["products" => $products]);
    }

    public function addProduct(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'category' => 'required',
            'name' => 'required',
            'description' => 'required',
            'price' => 'required',
            'image'   => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($validation->fails()) return back()->withInput()->with('warning', implode('<br>', $validation->errors()->all()));

        $productImage = $request->file('image');
        $productImagePath = $productImage;

        if ($productImage) {
            $productImagePath = $productImage->store();
            $productImage->move(public_path('product_img/'), $productImagePath);
        }

        Products::create([
            'categoryID' => $request->category,
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'image'    => $productImagePath,
        ]);

        return back()->with('success', "Successfully Added.");
    }

    public function updateProduct(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'name' => 'required',
            'description' => 'required',
            'productPrice' => 'required',
            'image'   => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($validation->fails()) return back()->withInput()->with('warning', implode('<br>', $validation->errors()->all()));

        $image       = $request->file('image');
        $product = $this->products->where('productID', $request->productID)->first();
        $productData = [
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->productPrice
        ];

        if ($image) {
            $image               = $image->store();
            $productImageOld            = $product->image;
            $productData['image'] = $image;
            $request->image->move(public_path('product_img/'), $image);

            if ($productImageOld) {
                $productImageOldPath = public_path('product_img/' . $productImageOld);

                if (file_exists($productImageOldPath)) unlink($productImageOldPath);
            }
        }

        Products::where('productID', $request->productID)->update($productData);

        return back()->with('success', 'Successfully Updated.');
    }

    public function removeProduct(Request $request)
    {
        $product = $this->products->where('productID', $request->id)->first();
        
        $image = $product->image;

        if ($image) {
            $imagePath = public_path('product_img/' . $image);

            if (file_exists($imagePath)) unlink($imagePath);
        }

        Products::where('productID', $request->id)->delete();

        return $product ? response([]) : response(['status' => 'warning', 'message' => 'Failed to delete product']);
    }

    public function getByCategory(Request $request)
    {
        $products = Products::where('CategoryID', $request->category_id)->get();

        return response(["products" => $products]);
    }

    public function getByPrice(Request $request)
    {
        $products = [];

        switch ($request->price_range) {
            case "High":
                $products = Products::orderByDesc('Price')->get();
                break;
            case "Low":
                $products = Products::orderBy('Price')->get();
                break;
        }

        return response(["products" => $products]);
    }

    public function addOrder(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'quantity' => 'required'
        ]);

        if ($validation->fails()) return back()->withInput()->with('warning', implode('<br>', $validation->errors()->all()));

        $products = Products::where('productID', $request->productID)->first();

        if ($products) {
            Orders::create([
                'quantity' => $request->quantity,
                'totalPrice' => $products->price,
                'orderDate' => now(),
                'status' => "Pending",
                'userID' => auth()->user()->id,
                'productID' => $request->productID,
            ]);

            return back()->with('success', "Successfully Ordered.");
        }
    }

    public function checkout(Request $request)
    {
        $productIDs = $request->productIDs;
        $productIDsArray = explode(',', $productIDs);
        Orders::where('userID', auth()->user()->id)->whereIn('productID', $productIDsArray)->update(['status' => 'Completed']);
        return redirect()->back()->with('success', 'Products checked out successfully.');
    }
}
