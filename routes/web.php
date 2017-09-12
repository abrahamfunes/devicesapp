<?php

use App\Models\Product;

Route::get('api/v1/models', function () {
    return \App\Models\Model::whereStatusId(1)->whereTypeId(3)->orderBy('name')->get()->pluck('name');
});

Route::get('api/v1/{model_name}', function ($model_name) {

    $device = Product::with(['model', 'productsGallery'])->whereIn('status_id', [1, 2, 4])->get()->map(function ($item) use ($model_name) {
        if ($app = $item->model->mobileApp != null)
            if (str_slug($item->model->mobileApp->model_name) === str_slug($model_name)) return $item;
    })->reject(function ($item) {
        return empty($item);
    })->first();

    $faqs = [];
    $sliders = [];
    $devices = null;

    if ($device)
    {
        $data_sheet = $device->productsFiles()->whereName('data.sheet')->first();

        if ($data_sheet)
            $data_sheet = 'https://lanix.com/files/' . $data_sheet->id;

        $characteristics = [];

        array_push(
            $characteristics,
            $device->productsItems()->whereStatusId(1)->get()->map(function ($item) {
                return [
                    'name'        => $item->type->name,
                    'description' => $item->description,
                ];
            })
        );

        $gallery = [];

        array_push(
            $gallery,
            $device->productsGallery()->get()->map(function ($item) {
                return [
                    ['image' => "https://lanix.com/" . $item->path],
                ];
            })
        );

        $faqs = $device->model->faqs()->select(['question','answer'])->get();
        $sliders = $device->model->sliders()->select(['name','image','url'])->get();

        $device = [
            'model'           => $device->model->name,
            'description'     => $device->model->description,
            'data_sheet'      => $data_sheet ? $data_sheet : null,
            'characteristics' => $characteristics[0],
            'gallery'         => $gallery[0],
        ];

    } else
    {
        $devices = \App\Models\Model::whereStatusId(1)->whereTypeId(3)->orderBy('name')->get()->pluck('name');
    }

    $data = [
        'device'          => $device,
        'avalibledevices' => $devices,
        'slider'          => $sliders,
        'faqs'            => [
            'general' => \App\Models\MobileFaq::whereModelId(null)->whereStatusId(1)->select(['question','answer'])->get(),
            'model'   => $faqs,
        ],
    ];

    $responsecode = 200;

    $header = [
        'Content-Type' => 'application/json; charset=UTF-8',
        'charset'      => 'utf-8',
    ];

    json_encode($data, JSON_UNESCAPED_SLASHES);

    $response = response()->json($data, $responsecode, $header, JSON_UNESCAPED_UNICODE);

    return $response;

});

