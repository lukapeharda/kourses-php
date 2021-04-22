<?php

namespace Kourses;

/**
 * @property string $id
 * @property string $email
 * @property string $firstName
 * @property string $lastName
 * @property \Kourses\Collection $products
 */
class Member extends DataTransferObject
{
    /**
     * Products accessor.
     *
     * @return  \Kourses\Collection
     */
    public function getProductsAttribute()
    {
        return $this->convertProductsArrayToHydratedProductCollection();
    }

    /**
     * Convert member's products from array in data to a hydrated collection.
     *
     * @return  \Kourses\Collection
     */
    protected function convertProductsArrayToHydratedProductCollection()
    {
        if ( ! isset($this->data['products']) || empty($this->data['products']) || count($this->data['products']) === 0) {
            return new Collection();
        }

        return (new Collection($this->data['products']))->map(function ($product) {
            return new Product($product);
        });
    }
}
