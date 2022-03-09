<?php

namespace KoursesPhp;

/**
 * @property string $id
 * @property string $title
 * @property string $type
 * @property string $subtitle
 * @property string $slug
 * @property string $url
 * @property object|null $image
 */
class Product extends DataTransferObject
{
    /**
     * Product image accessor.
     *
     * Converts array of images into object.
     *
     * @return  object|null
     */
    public function getImageAttribute()
    {
        if (isset($this->image) && ! empty($this->image)) {
            return (object) $this->image;
        }

        return null;
    }
}
