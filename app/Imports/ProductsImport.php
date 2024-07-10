<?php

namespace App\Imports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Log;

class ProductsImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {

        if (!isset($row['status'])) {
            return null;
        }

        if ($row['status'] === 'Sold') {
            // Perform the necessary updates based on your requirements
            $product = Product::where('id', $row['product_id'])->first();

            Log::debug($product);

            if ($product) {
                $product->update([
                    'quantity' => $product->quantity - 1,
                    // other fields to update
                ]);
                $product->save();
            } else if ($row['status'] === 'Buy') {
                // If the status is buy, then add in more quanity to the stock
                $product->update([
                    'quantity' => $product->quantity + 1,
                    // other fields to update
                ]);
                $product->save();
            }
        }

        return null;
    }
}
