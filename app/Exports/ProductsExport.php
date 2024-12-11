<?php
namespace App\Exports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ProductsExport implements FromCollection, WithHeadings, WithMapping
{

    public function headings(): array
    {
        return [
            trans("Name"),
            trans("Category"),
            trans("Brand"),
            trans("Date Arrival"),
            trans("Price"),
            trans("Quantity"),
            trans("Quantity Alert"),
            trans("Source"),
            trans("Specification"),
            trans("Notes"),
        ];
    }

    public function map($product): array
    {
        return [
            $product->name,
            $product->category->name,
            $product->brand,
            $product->dateArrival,
            $product->price,
            $product->quantity,
            $product->quantity_alert,
            $product->source,
            $this->formatSpecification($product->specification),
            $product->notes,
        ];
    }
    public function collection()
    {
        return Product::all();
    }

    private function formatSpecification($specification)
    {
        // Remove HTML tags and convert list items to a comma-separated string
        $specification = strip_tags($specification, '<li>');
        $specification = str_replace(['<li>', '</li>'], ['', ', '], $specification);
        return trim($specification, ', ');
    }
}
