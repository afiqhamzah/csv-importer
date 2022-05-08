<?php

namespace App\Imports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithUpserts;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Illuminate\Contracts\Queue\ShouldQueue;

class ProductsImport implements ToModel, WithStartRow, WithUpserts, WithChunkReading, WithBatchInserts, ShouldQueue
{

    protected $product_document_id;

    public function __construct($product_document_id)
    {
	    $this->product_document_id = $product_document_id;
    }
	    

    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
	$clearNonUTF8 = fn($x) => iconv("UTF-8", "UTF-8//IGNORE", $x); 

	$row = array_map($clearNonUTF8, $row);

        return new Product([
            'product_document_id'=> $this->product_document_id,
            'unique_key'=> $row[0],
            'product_title'=> $row[1],
            'product_description'=> $row[2],
            'style#'=> $row[3],
            'available_sizes'=> $row[4],
            'brand_logo_image'=> $row[5],
            'thumbnail_image'=> $row[6],
            'color_swatch_image'=> $row[7],
            'product_image'=> $row[8],
            'spec_sheet'=> $row[9],
            'price_text'=> $row[10],
            'suggested_price'=> $row[11],
            'category_name'=> $row[12],
            'subcategory_name'=> $row[13],
            'color_name'=> $row[14],
            'color_square_image'=> $row[15],
            'color_product_image'=> $row[16],
            'color_product_image_thumbhnail'=> $row[17],
            'size'=> $row[18],
            'qty'=> $row[19],
            'piece_weight'=> $row[20],
            'piece_price'=> $row[21],
            'dozens_price'=> $row[22],
            'case_price'=> $row[23],
            'price_group'=> $row[24],
            'case_size'=> $row[25],
            'inventory_key'=> $row[26],
            'size_index'=> $row[27],
            'sanmar_mainframe_color'=> $row[28],
            'mill'=> $row[29],
            'product_status'=> $row[30],
            'companion_styles'=> $row[31],
            'msrp'=> $row[32],
            'map_pricing'=> $row[33],
            'front_model_image_url'=> $row[34],
            'back_model_image'=> $row[35],
            'front_flat_image'=> $row[36],
            'back_flat_image'=> $row[37],
            'product_measurements'=> $row[38],
            'pms_color'=> $row[39],
            'gtin'=> $row[40],
        ]);
    }

    public function startRow(): int
    {
            return 2;
    }

    public function uniqueBy()
    {
            return 'product_document_id';
    }


    public function chunkSize(): int
    {
	    return 500;
    }

    public function batchSize(): int
    {
	    return 500;
    }

}
