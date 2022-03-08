<?php

namespace KoursesPhp;

/**
 * @property string $id
 * @property string $email
 * @property string $firstName
 * @property string $lastName
 * @property \KoursesPhp\Collection $products
 * @property string $status
 */
class Member extends DataTransferObject
{
    const STATUS_CREATED = 'created';
    const STATUS_UPDATED = 'updated';

    /**
     * Products accessor.
     *
     * @return  \KoursesPhp\Collection
     */
    public function getProductsAttribute()
    {
        return $this->convertProductsArrayToHydratedProductCollection();
    }

    /**
     * Convert member's products from array in data to a hydrated collection.
     *
     * @return  \KoursesPhp\Collection
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
