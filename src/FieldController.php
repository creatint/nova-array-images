<?php

namespace Creatint\ArrayImages;

use Illuminate\Support\Facades\Storage;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;

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

        foreach ($images as $image) {
            $savedImage = Storage::disk($disk)
                ->putFile($path, $image);

            $data[] = [
                'src' => $savedImage,
                'url' => Storage::disk($disk)->url($savedImage),
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

        return array_map(function ($src) use ($disk) {
            if (strpos($src, 'http') !== 0) {
                return ['src' => $src, 'url' => Storage::disk($disk)->url($src)];
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

        return "fail";
    }
}
