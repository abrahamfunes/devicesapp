<?php

use App\Models\Product;

Route::get('api/v1/models', function() {

    return \App\Models\Model::whereStatusId(1)->whereTypeId(3)->orderBy('name')->get()->pluck('name');

});

Route::get('api/v1/{model_name}', function ($model_name) {

    /*
     * ilium-l100
     * */

    $device = Product::with(['model', 'productsGallery'])->whereIn('status_id', [1, 2, 4])->get()->map(function ($item) use ($model_name) {
        if (str_slug($item->model->name) === str_slug($model_name)) return $item;
    })->reject(function ($item) {
        return empty($item);
    })->first();

    $faqs = [];
    $devices = null;

    if ($device) {

        $data_sheet = $device->productsFiles()->whereName('data.sheet')->first();

        if ($data_sheet)
            $data_sheet = 'https://lanix.com/files/' . $data_sheet->id;

        $characteristics = [];

        array_push(
            $characteristics,
            $device->productsItems()->whereStatusId(1)->get()->map(function ($item) {
                return [
                    'name' => $item->type->name,
                    'description' => $item->description,
                ];
            })
        );

        $gallery = [];


        array_push(
            $gallery,
            $device->productsGallery()->get()->map(function ($item) {
                return [
                    ['image' => "https://lanix.com/".$item->path],
                ];
            })
        );

        $gallery = array(
            ['image' =>  "https://lanix.com/mobileapp/galeria/a.png"],
            ['image' =>  "https://lanix.com/mobileapp/galeria/b.png"],
            ['image' =>  "https://lanix.com/mobileapp/galeria/c.png"],
        );

        #$gallery[0][2] = ['image' =>  "https://lanix.com/mobileapp/galeria/a.png"];
//        array_push(
//            $gallery[0],
//            ['image' =>  "https://lanix.com/mobileapp/galeria/b.png"]
//        );
//        array_push(
//            $gallery[0],
//            ['image' =>  "https://lanix.com/mobileapp/galeria/c.png"]
//        );

        $device = [
            'model' => $device->model->name,
            'description' => $device->model->description,
            'data_sheet' => $data_sheet ? $data_sheet : null,
            'characteristics' => $characteristics[0],
            'gallery' => $gallery[0]
        ];

        $faqs = [
            ['question' => 'Pregunta 1', 'answer' => 'Respuesta 1'],
            ['question' => 'Pregunta 2', 'answer' => 'Respuesta 2'],
        ];

    }else{
        $devices = \App\Models\Model::whereStatusId(1)->whereTypeId(3)->orderBy('name')->get()->pluck('name');
    }

    $data = [
        'device' => $device,
        'avalibledevices' => $devices,
        'slider' => [
            ["name" => "Lanix Mobile", "image" => 'https://lanix.com/mobileapp/slider/1.jpg', "url" => "",],
            ["name" => "Laptops poderosas", "image" => 'https://lanix.com/mobileapp/slider/2.jpg', "url" => "",],
            ["name" => "Velocidad de procesamiento", "image" => 'https://lanix.com/mobileapp/slider/3.jpg', "url" => "",],
            ["name" => "Lo mejor del mercado", "image" => 'https://lanix.com/mobileapp/slider/4.jpg', "url" => "",],
        ],
        'faqs' => [
            'general' => [
                ['question' => 'Pregunta 1', 'answer' => 'Respuesta 1'],
                ['question' => 'Pregunta 2', 'answer' => 'Respuesta 2'],
            ],
            'model' => $faqs,
        ],
    ];

    $responsecode = 200;

    $header = array (
        'Content-Type' => 'application/json; charset=UTF-8',
        'charset' => 'utf-8'
    );

    json_encode($data, JSON_UNESCAPED_SLASHES);

    $response = response()->json($data , $responsecode, $header, JSON_UNESCAPED_UNICODE);
    #$response->header('Content-Type', 'application/json');
    #$response->header('charset', 'utf-8');
    return $response;
});

