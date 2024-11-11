<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Http\Requests\Product\StoreProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;
use App\Models\Category;
use App\Models\Product;
use App\Models\Unit;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Http\Request;
use Picqer\Barcode\BarcodeGeneratorHTML;
use Str;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::where("user_id", auth()->id())->count();

        return view('products.index', [
            'products' => $products,
        ]);
    }

    public function showByID($id)
    {
        $product = Product::findOrFail($id); // Ambil produk berdasarkan ID

        return view('item-detail', compact('product')); // Kirim data ke view
    }

    public function admin_dashboard(Request $request)
    {
        $query = Product::query();

        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                ->orWhere('brand', 'LIKE', "%{$search}%")
                ->orWhere('source', 'LIKE', "%{$search}%")
                ->orWhereHas('category', function($q) use ($search) {
                    $q->where('name', 'LIKE', "%{$search}%");
                });
            });
        }

        $products = $query->with('category')->paginate(10);

        //also get the categories

        $categories = Category::where("user_id", auth()->id())->get(['id', 'name']);

        $lowStockCount = Product::whereColumn('quantity', '<=', 'quantity_alert')->count();

        return view('dashboard-admin-items', [
            'products' => $products,
            'categories' => $categories,
            'lowStockCount' => $lowStockCount
        ]);
    }

    public function user_dashboard(Request $request)
    {
        $query = Product::query();

        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                ->orWhere('brand', 'LIKE', "%{$search}%")
                ->orWhere('source', 'LIKE', "%{$search}%")
                ->orWhereHas('category', function($q) use ($search) {
                    $q->where('name', 'LIKE', "%{$search}%");
                });
            });
        }

        $products = $query->paginate(9);

        return view('dashboard-reg-items', [
            'products' => $products,
        ]);
    }

    public function create(Request $request)
    {
        $categories = Category::where("user_id", auth()->id())->get(['id', 'name']);
        $units = Unit::where("user_id", auth()->id())->get(['id', 'name']);

        if ($request->has('category')) {
            $categories = Category::where("user_id", auth()->id())->whereSlug($request->get('category'))->get();
        }

        if ($request->has('unit')) {
            $units = Unit::where("user_id", auth()->id())->whereSlug($request->get('unit'))->get();
        }

        return view('products.create', [
            'categories' => $categories,
            'units' => $units,
        ]);
    }

    public function store(StoreProductRequest $request)
    {

        /**
         * Handle specification input
         */

        $specifications = explode("\n", $request->specification);

        // Buat list HTML
        $htmlSpecification = '';
        foreach ($specifications as $spec) {
            $htmlSpecification .= '<li>' . e(trim($spec)) . '</li>';
        }

        /**
         * Handle upload image
         */
        if ($request->hasFile('product_image')) {
            $imageFile = $request->file('product_image');
            $imageData = file_get_contents($imageFile->getRealPath());
        } else {
            $imageData = null;
        }

        Product::create([
            "code" => IdGenerator::generate([
                'table' => 'products',
                'field' => 'code',
                'length' => 4,
                'product_image' => $imageData,
                'specification'=> $request->specification,
                'prefix' => 'PC'
            ]),

            'product_image'     => $imageData,
            'name'              => $request->name,
            'category_id'       => $request->category_id,
            'quantity'          => $request->quantity,
            'quantity_alert'    => $request->quantity_alert,
            'notes'             => $request->notes,
            'specification'     => $htmlSpecification,
            'price'             => $request->price,
            'brand'             => $request->brand,
            'source'            => $request->source,
            'dateArrival'       => $request->dateArrival,
            'user_id'           => auth()->id(),
            'slug'              => Str::slug($request->name, '-'),
            'uuid'              => Str::uuid()
        ]);
        return to_route('dashboard-admin-items')->with('success', 'Product has been created!');
    }

    public function show($uuid)
    {
        $product = Product::where("uuid", $uuid)->firstOrFail();
        // Generate a barcode
        $generator = new BarcodeGeneratorHTML();

        $barcode = $generator->getBarcode($product->code, $generator::TYPE_CODE_128);

        return view('products.show', [
            'product' => $product,
            'barcode' => $barcode,
        ]);
    }

    public function edit($uuid)
    {
        $product = Product::where("uuid", $uuid)->firstOrFail();
        return view('products.edit', [
            'categories' => Category::where("user_id", auth()->id())->get(),
            'product' => $product
        ]);
    }


    public function update(UpdateProductRequest $request, $uuid)
    {
        $product = Product::where("uuid", $uuid)->firstOrFail();
        $product->update($request->except('product_image'));

        $image = $product->product_image;
        if ($request->hasFile('product_image')) {
            // Delete Old Photo
            if ($product->product_image && file_exists(public_path('storage/' . $product->product_image))) {
                unlink(public_path('storage/' . $product->product_image));
            }
            $image = $request->file('product_image')->store('products', 'public');
        }


        $product->name = $request->name;
        $product->slug = Str::slug($request->name, '-');
        $product->category_id = $request->category_id;
        $product->quantity = $request->quantity;
        $product->price = $request->price;
        $product->quantity_alert = $request->quantity_alert;
        $product->notes = $request->notes;
        $product->source = $request->source;
        $product->specification = $request->specification;
        $product->dateArrival = $request->dateArrival;
        $product->brand = $request->brand;
        $product->product_image = $image;
        $product->save();


        return redirect()
            ->route('dashboard-admin-items')
            ->with('success', 'Product has been updated!');
    }

    public function destroy($uuid)
    {
        $product = Product::where("uuid", $uuid)->firstOrFail();
        /**
         * Delete photo if exists.
         */
        if ($product->product_image) {
            // check if image exists in our file system
            if ($product->product_image && file_exists(public_path('storage/' . $product->product_image))) {
                unlink(public_path('storage/' . $product->product_image));
            }

        }

        $product->delete();

        return redirect()
            ->route('dashboard-admin-items')
            ->with('success', 'Product has been deleted!');
    }

    public function getImage($uuid)
    {
        $product = Product::where('uuid', $uuid)->firstOrFail();

        $imageData = $product->product_image; // Assuming this is the BLOB field
        $mimeType = 'image/png'; // Adjust this according to the actual image MIME type

        return response($imageData)
        ->header('Content-Type', $mimeType)
        ->header('Cache-Control', 'public, max-age=604800');
    }
}
