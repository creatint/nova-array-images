<?php

namespace Creatint\ArrayImages;

use Illuminate\Support\Facades\Storage;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;

$arrayImagesDisk = 'default';

if (!function_exists('getFileUrl')) {
    function getFileUrl($src) {
        global $arrayImagesDisk;
        return Storage::disk($arrayImagesDisk)->url($src);
    }
}

class FieldController extends BaseController
{
    /**
     * upload selected images
     *
     * @param Request $request
     * @return array
     */
    public function upload(Request $request)
    {
        $disk = $request->input('disk', 'local');
        $path = $request->input('path', '/');
        $images = $request->images;
        $data = array();

        global $arrayImagesDisk;
        $arrayImagesDisk = $disk;

        foreach ($images as $image) {
            $savedImage = Storage::disk($disk)
                ->putFile($path, $image);

            $data[] = [
                'src' => $savedImage,
                'url' => getFileUrl($savedImage),
            ];
        }

        return $data;
    }

    public function urls(Request $request)
    {
        $disk = $request->input('disk', 'local');
        $srcs = $request->input('srcs');

        if (empty($srcs)) {
            return [];
        }

        global $arrayImagesDisk;
        $arrayImagesDisk = $disk;

        return array_map(function ($src) use ($disk) {
            if (strpos($src, 'http') !== 0) {
                return ['src' => $src, 'url' => getFileUrl($src)];
            }
            return ['src' => $src, 'url' => $src];
        }, $srcs);
    }

    public function delete(Request $request)
    {
        $src = $request->input('src');
        $disk = $request->input('disk', 'local');
        $path = $request->input('path', '/');

        if (empty($src)) {
            return 'success';
        }

        if (!Storage::disk($disk)->exists($src)) {
            return 'success';
        }

        if (strpos($src, $path) === 0) {
            Storage::disk($disk)->delete($src);
            return "success";
        }

        return "success";
    }
}
