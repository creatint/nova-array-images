<?php

namespace Halimtuhu\ArrayImages;

use Laravel\Nova\Fields\AcceptsTypes;
use Laravel\Nova\Fields\Field;

class ArrayImages extends Field
{

    use AcceptsTypes;

    /**
     * The field's component.
     *
     * @var string
     */
    public $component = 'array-images';

    /**
     * Create a new field.
     *
     * @param  string  $name
     * @param  string|null  $attribute
     * @param  string|null  $disk
     * @param  callable|null  $storageCallback
     * @return void
     */
    public function __construct($name, $attribute = null, $disk = 'public', $storageCallback = null)
    {
        parent::__construct($name, $attribute, $storageCallback);

        $this->disk($disk);
        $this->acceptedTypes('image/*');
        $this->buttonTitle('Upload Image');

    }

    /**
     * Specify target disk
     *
     * @param $disk
     * @return ArrayImages
     */
    public function disk($disk)
    {
        return $this->withMeta([
            'disk' => $disk
        ]);
    }

    /**
     * Specify target path
     *
     * @param $path
     * @return ArrayImages
     */
    public function path($path)
    {
        return $this->withMeta([
            'path' => $path
        ]);
    }

    public function buttonTitle($title) {
        return $this->withMeta([
            'buttonTitle' => $title
        ]);
    }
}
