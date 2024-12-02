<?php

namespace App\Imports;

use App\Models\Product;
use App\Models\Category;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Str;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Carbon\Carbon;

class ProductsImport implements ToModel, WithHeadingRow
{
    public $ignoredProducts = [];

    public function model(array $row)
    {
        // Check if a product with the same name exists
        $existingProduct = Product::where('name', 'LIKE', $row['name'])->first();

        if ($existingProduct) {
            // Collect the name for the message
            $this->ignoredProducts[] = $row['name'];
            // Skip this row
            return null;
        }

        // Find or create the category based on the name
        $category = Category::firstOrCreate([
            'name' => $row['category'],
        ]);

        // Process specification to HTML list
        $specifications = explode(',', $row['specification']);
        $htmlSpecification = '';
        foreach ($specifications as $spec) {
            $htmlSpecification .= '<li>' . e(trim($spec)) . '</li>';
        }

        $dateArrival = $this->transformDate($row['date_arrival']);


        // Create a new product
        return new Product([
            'name' => $row['name'],
            'category_id' => $category->id,
            'brand' => $row['brand'],
            'dateArrival' => $dateArrival,
            'price' => $row['price'],
            'quantity' => $row['quantity'],
            'quantity_alert' => $row['quantity_alert'],
            'source' => $row['source'],
            'specification' => $htmlSpecification,
            'notes' => $row['notes'],
            'user_id' => auth()->id(),
            'slug' => Str::slug($row['name'], '-'),
            'uuid' => Str::uuid(),
            "code" => IdGenerator::generate([
                'table' => 'products',
                'field' => 'code',
                'length' => 4,
                'specification' => $row['specification'],
                'prefix' => 'PC'
            ]),
        ]);
    }
    private function transformDate($value)
    {
        // Check if the value is a numeric Excel date serial number
        if (is_numeric($value)) {
            // Convert Excel date serial number to a Carbon date
            return Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($value))->format('Y-m-d');
        }

        // If it's not a numeric value, assume it's already in d/m/Y format
        return Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d');
    }
}
