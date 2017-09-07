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
                    'image' => "https://lanix.com/".$item->path,
                ];
            })
        );

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

    }

    $data = [
        'device' => $device,
        'slider' => [
            ["name" => "Slider 1", "image" => "http://slider1.jpg", "url" => "http://abrir-esta-liga-en-navegador-1",],
            ["name" => "Slider 2", "image" => "http://slider2.jpg", "url" => "http://abrir-esta-liga-en-navegador-2",],
        ],
        'faqs' => [
            'general' => [
                ['question' => 'Pregunta 1', 'answer' => 'Respuesta 1'],
                ['question' => 'Pregunta 2', 'answer' => 'Respuesta 2'],
            ],
            'model' => $faqs,
        ],
    ];

    return response()->json($data);
});

