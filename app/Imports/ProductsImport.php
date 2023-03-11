<?php

namespace App\Imports;

use App\Models\Category;
use App\Models\Product;
use Maatwebsite\Excel\Concerns\ToArray;
use Maatwebsite\Excel\Concerns\WithChunkReading;

use Maatwebsite\Excel\Concerns\WithStartRow;


class ProductsImport implements ToArray, WithStartRow, WithChunkReading
{

    private array $categories = [];
    private int $rowCount = 0;
    private int $rowSize = 10; 

    public function __construct(private int $fileChunkSize, private int $queryChunkSize) {
        
    }

    public function getRowCount(): int {
        return $this->rowCount;
    }

    public function array(array $array) {
        $products = [];
        foreach($array as $row){
            ++$this->rowCount;
            if(count($row) > $this->rowSize && !is_null(end($row))){
                array_shift($row);
            }

            if(!isset($this->categories[0][$row[0] ?? $row[1]]))
                $this->categories[0][$row[0] ?? $row[1]] = ['name' => $row[0] ?? $row[1]];
            if(!is_null($row[0]) && !isset($this->categories[1][$row[1]]))
                $this->categories[1][$row[1]] = ['name' => $row[1], 'parent_id' => $row[0]];
            if(!isset($this->categories[2][$row[2]]))
                $this->categories[2][$row[2]] =  ['name' => $row[2], 'parent_id' => $row[1]];

            $products[$row[5]] = [
                'category_name' => $row[2],
                'manufacturer' => $row[3],
                'name' => $row[4],
                'code' => $row[5],
                'description' => $row[6],
                'price' => (float)$row[7],
                'warranty' => (int)$row[8],
                'availability' => $row[9]
            ];
        }
        $dbCategories = null;
        foreach($this->categories as $key => $value) {
            if(isset($this->categories[$key - 1])){
                $dbCategories = Category::all()->pluck('id', 'name');
                foreach($value as $index => $category){
                    if(!is_numeric($value[$index]['parent_id'])){
                        $value[$index]['parent_id'] = $dbCategories[$category['parent_id']];
                        $this->categories[$key][$index]['parent_id'] = $dbCategories[$category['parent_id']];
                    }
                }
            }
            Category::upsert($value, ['name']);
        }

        $dbCategories = Category::all()->pluck('id', 'name');
        foreach($products as $key => $product){
            
            $products[$key]['category_id'] = $dbCategories[$product['category_name']];
            unset($products[$key]['category_name']);
        }
        $chunks = array_chunk($products, $this->queryChunkSize, true);

        foreach($chunks as $chunk){
            Product::upsert($chunk, ['code']);
        }

    }

    public function chunkSize(): int
    {
        return $this->fileChunkSize;
    }


    public function startRow(): int
    {
        return 2;
    }
}
