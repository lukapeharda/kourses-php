<?php

namespace KoursesPhp\Service;

use KoursesPhp\Product;
use KoursesPhp\PaginationMetadata;
use KoursesPhp\PaginatedCollection;

class ProductsService extends AbstractService
{
    /**
     * Returns a paginated collection list with published products.
     *
     * @param   array  $params
     *
     * @return  \KoursesPhp\PaginatedCollection
     */
    public function all($params = null)
    {
        $response = $this->request('get', 'v1/products', $params);

        $products = [];

        if (is_array($response['data']) && count($response['data'])) {
            $products = array_map(function ($item) {
                return new Product($item);
            }, $response['data']);
        }

        $collection = new PaginatedCollection($products);

        if (isset($response['meta'])) {
            $collection->setPaginationMetadata(new PaginationMetadata($response['meta']));
        }

        return $collection;
    }
}
