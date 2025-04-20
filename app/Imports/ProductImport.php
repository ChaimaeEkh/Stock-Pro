<?php
namespace App\Imports;
use Throwable;
use App\Models\Product;
use App\Models\Category;
use App\Models\Supplier;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class ProductImport implements ToModel, WithHeadingRow, WithValidation
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        try {
            // Vérifier que les colonnes nécessaires existent
            if (!isset($row['id']) || !isset($row['name']) || !isset($row['price']) ||
                !isset($row['category']) || !isset($row['supplier'])) {
                return null;
            }

            $product = Product::where('id', $row['id'])->first();
            if ($product) {
                // Mettre à jour le produit existant si nécessaire
                $product->update([
                    'name' => $row['name'],
                    'description' => $row['description'] ?? '',
                    'price' => $row['price'],
                ]);
                return null;
            }

            $category = Category::where('name', $row['category'])->first();
            if(!$category) {
                $category = Category::create(['name' => $row['category']]);
            }

            $supplier = Supplier::where(DB::raw("CONCAT(first_name, ' ', last_name)"), $row['supplier'])->first();
            if(!$supplier) {
                $fullName = $row['supplier'];
                $parts = explode(' ', trim($fullName), 2);
                $firstName = $parts[0] ?? '';
                $lastName = $parts[1] ?? '';
                $supplier = Supplier::create([
                    'first_name' => $firstName,
                    'last_name' => $lastName,
                    'phone' => $row['supplier_phone'] ?? '',
                ]);
            }

            return new Product([
                'id' => $row['id'],
                'name' => $row['name'],
                'description' => $row['description'] ?? '',
                'price' => $row['price'],
                'category_id' => $category->id,
                'supplier_id' => $supplier->id
            ]);
        } catch (Throwable $e) {
            Log::error('Erreur lors de l\'importation d\'un produit: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function rules(): array
    {
        return [
            'id' => 'required|integer',
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'category' => 'required|string|max:255',
            'supplier' => 'required|string|max:255',
        ];
    }

    public function headingRow(): int
    {
        return 1;
    }
}
