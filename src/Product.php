<?php

namespace Kourses;

/**
 * @property string $id
 * @property string $title
 * @property string $type
 * @property string $subtitle
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
