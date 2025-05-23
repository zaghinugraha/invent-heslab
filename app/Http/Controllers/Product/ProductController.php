<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Http\Requests\Product\StoreProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;
use Maatwebsite\Excel\Validators\ValidationException;
use App\Models\Category;
use App\Models\Maintenance;
use App\Models\Product;
use App\Models\Unit;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ProductsExport;
use Log;
use Picqer\Barcode\BarcodeGeneratorHTML;
use Str;
use App\Imports\ProductsImport;

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

    public function search(Request $request)
    {
        // Get the search query from the request
        $query = $request->input('q');

        $products = Product::where('name', 'LIKE', "%{$query}%")
            ->orWhere('brand', 'LIKE', "%{$query}%")
            ->select('id', 'uuid', 'name', 'price', 'quantity', 'quantity_alert', 'brand', 'source', 'dateArrival', 'notes', 'specification')
            ->get();

        return response()->json($products, 200);
    }

    public function
        admin_dashboard(
        Request $request
    ) {
        $query = Product::query();

        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                    ->orWhere('brand', 'LIKE', "%{$search}%")
                    ->orWhere('source', 'LIKE', "%{$search}%")
                    ->orWhereHas('category', function ($q) use ($search) {
                        $q->where('name', 'LIKE', "%{$search}%");
                    });
            });
        }

        $products = $query->with('category')->paginate(10);

        $productsWithMaintenance = Product::with(['maintenance'])->get();

        $needMaintenanceCount = $productsWithMaintenance->filter(function ($product) {
            $lastMaintenance = $product->maintenance->sortByDesc('created_at')->first();
            $referenceDate = $lastMaintenance ? \Carbon\Carbon::parse($lastMaintenance->created_at) : \Carbon\Carbon::parse($product->dateArrival);
            return $referenceDate->diffInDays(now()) >= 7;
        })->count();

        $categories = Category::all();

        $lowStockCount = Product::whereColumn('quantity', '<', 'quantity_alert')->count();

        return view('dashboard-admin-items', [
            'products' => $products,
            'categories' => $categories,
            'lowStockCount' => $lowStockCount,
            'needMaintenanceCount' => $needMaintenanceCount,
        ]);
    }

    public function user_dashboard(Request $request)
    {
        $query = Product::query();

        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                    ->orWhere('brand', 'LIKE', "%{$search}%")
                    ->orWhere('source', 'LIKE', "%{$search}%")
                    ->orWhereHas('category', function ($q) use ($search) {
                        $q->where('name', 'LIKE', "%{$search}%");
                    });
            });
        }

        if ($request->has('category') && $request->category != 'all') {
            $query->where('category_id', $request->category);
        }

        if ($request->has('availability') && $request->availability != 'all') {
            if ($request->availability == 'available') {
                $query->where('is_rentable', true)->where('quantity', '>', 0);
            } elseif ($request->availability == 'unavailable') {
                $query->where(function ($q) {
                    $q->where('is_rentable', false)
                        ->orWhere('quantity', '<=', 0);
                });
            }
        }

        $products = $query->paginate(9);
        $categories = Category::all();

        return view('dashboard-reg-items', [
            'products' => $products,
            'categories' => $categories,
            'selectedCategory' => $request->category,
            'selectedAvailability' => $request->availability,
            'searchQuery' => $request->search,
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
                'specification' => $request->specification,
                'prefix' => 'PC'
            ]),

            'product_image' => $imageData,
            'name' => $request->name,
            'category_id' => $request->category_id,
            'quantity' => $request->quantity,
            'quantity_alert' => $request->quantity_alert,
            'notes' => $request->notes,
            'specification' => $htmlSpecification,
            'price' => $request->price,
            'brand' => $request->brand,
            'source' => $request->source,
            'dateArrival' => $request->dateArrival,
            'user_id' => auth()->id(),
            'slug' => Str::slug($request->name, '-'),
            'uuid' => Str::uuid()
        ]);
        return to_route('dashboard-admin-items')->with('success', 'Barang telah ditambahkan');
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

        // Store original attributes for change detection
        $originalData = $product->getOriginal();

        $product->fill($request->only([
            'name',
            'category_id',
            'brand',
            'source',
            'dateArrival',
            'price',
            'is_rentable',
            'quantity',
            'quantity_alert',
            'notes',
        ]));

        // Handle the product image (if applicable)
        if ($request->hasFile('product_image')) {
            $imageFile = $request->file('product_image');
            $imageData = file_get_contents($imageFile->getRealPath());
            $product->product_image = $imageData;
        }

        // Handle specification
        if ($request->has('specification')) {
            $specifications = explode("\n", $request->input('specification'));
            $htmlSpecification = '';
            foreach ($specifications as $spec) {
                $spec = trim($spec);
                if ($spec !== '') {
                    $htmlSpecification .= "<li>{$spec}</li>";
                }
            }
            $product->specification = $htmlSpecification;
        }

        // Save the product with the updated data
        $product->save();

        // Detect changes
        $changes = [];
        foreach ($product->getChanges() as $attribute => $value) {
            if (in_array($attribute, ['updated_at'])) {
                continue;
            }

            $originalValue = $originalData[$attribute] ?? null;

            // Handle specification separately to strip HTML tags
            if ($attribute === 'specification') {
                // Strip HTML tags from both original and new values
                $originalSpec = strip_tags($originalValue);
                $newSpec = strip_tags($value);
                $changes[] = "Spesifikasi telah diganti dari '{$originalSpec}' menjadi '{$newSpec}'";
            } else if ($attribute === 'product_image') {
                $changes[] = "Gambar produk telah diubah";
            } else if ($attribute === "category_id") {
                $originalCategory = Category::find($originalValue);
                $newCategory = Category::find($value);
                $originalCategoryName = $originalCategory ? $originalCategory->name : 'Unknown';
                $newCategoryName = $newCategory ? $newCategory->name : 'Unknown';
                $changes[] = "Kategori produk telah diganti dari '{$originalCategoryName}' menjadi '{$newCategoryName}'";
            } else if ($attribute === "is_rentable") {
                $changes[] = $value ? "Produk sekarang dapat disewakan" : "Produk sekarang tidak dapat disewakan";
            } else {
                $changes[] = "{$attribute} telah diganti dari '{$originalValue}' menjadi '{$value}'";
            }
        }

        // Prepare maintenance notes
        $maintenanceNotes = implode("\n", $changes);
        if ($request->filled('maintenance_notes')) {
            $maintenanceNotes .= "\n" . $request->input('maintenance_notes');
        }

        // Create Maintenance record if there are changes or maintenance notes
        if (!empty($changes) || $request->filled('maintenance_notes') || $request->hasFile('maintenance_picture')) {
            $maintenance = new Maintenance();
            $maintenance->product_id = $product->id;
            $maintenance->user_id = auth()->id();
            $maintenance->notes = $maintenanceNotes;

            if ($request->hasFile('maintenance_picture')) {
                $pictureFile = $request->file('maintenance_picture');
                $pictureData = file_get_contents($pictureFile->getRealPath());
                $maintenance->documentation = $pictureData;
            }

            try {
                $maintenance->save();
            } catch (\Exception $e) {
                return redirect()
                    ->route('dashboard-admin-items')
                    ->withErrors('Terjadi kesalahan saat menyimpan catatan pemeliharaan.');
            }
        }

        return redirect()
            ->route('dashboard-admin-items')
            ->with('success', 'Barang telah diperbarui!');
    }

    public function destroy($uuid)
    {
        $product = Product::where("uuid", $uuid)->firstOrFail();

        $product->delete();

        return redirect()
            ->route('dashboard-admin-items')
            ->with('success', 'Barang telah dihapus!');
    }

    public function getImage($uuid)
    {
        $product = Product::where('uuid', $uuid)->firstOrFail();
        $imageData = $product->product_image;

        if ($imageData) {
            // Detect the MIME type
            $finfo = new \finfo(FILEINFO_MIME_TYPE);
            $mimeType = $finfo->buffer($imageData);

            return response($imageData)
                ->header('Content-Type', $mimeType);
        } else {
            // If there's no image, you can return a placeholder or a 404
            abort(404);
        }
    }

    public function import(Request $request)
    {
        $request->validate([
            'excel_file' => 'required|mimes:xlsx',
        ]);

        $import = new ProductsImport;

        try {
            Excel::import($import, $request->file('excel_file'));

            $ignoredProducts = $import->ignoredProducts;

            $message = 'Barang berhasil diimpor.';

            if (!empty($ignoredProducts)) {
                $ignoredNames = implode(', ', $ignoredProducts);
                $message .= ' Barang yang diabaikan: ' . $ignoredNames;
            }

            return redirect()->back()->with('success', $message);
        } catch (ValidationException $e) {
            $failures = $e->failures();
            // Handle validation failures
            return redirect()->back()->withErrors(['excel_file' => 'Terjadi kesalahan validasi pada file Excel.']);
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['excel_file' => 'Terjadi kesalahan saat mengimpor file Excel.']);
        }
    }
    public function export()
    {
        // rename the file with current date
        $filename = 'products-' . now()->format('Y-m-d') . '.xlsx';
        return Excel::download(new ProductsExport, $filename);
    }
}
