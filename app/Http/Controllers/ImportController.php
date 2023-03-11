<?php

namespace App\Http\Controllers;

use App\Http\Requests\ImportRequest;
use App\Imports\ProductsImport;
use App\Models\Product;
use Maatwebsite\Excel\Facades\Excel;

class ImportController extends Controller
{
    public function import(ImportRequest $request) {

        $startProductsCount = Product::count();
        $productsImport = new ProductsImport(2500, 100);

        Excel::import($productsImport, $request->file('import_file'));

        $endProductCount = Product::count();
        $fileRowsCount = $productsImport->getRowCount();
        $addedCount = $endProductCount - $startProductsCount;
        $duplicateCount = $fileRowsCount - $addedCount;

        return view('import', [
            'added' => $addedCount,
            'duplicate' => $duplicateCount,
            'rowsCount' => $fileRowsCount
        ]);

    }
}
