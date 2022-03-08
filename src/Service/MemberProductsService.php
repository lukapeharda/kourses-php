<?php

namespace KoursesPhp\Service;

use KoursesPhp\Product;
use KoursesPhp\PaginationMetadata;
use KoursesPhp\PaginatedCollection;
use KoursesPhp\Exception\InvalidArgumentException;

class MemberProductsService extends AbstractService
{
    /**
     * Fetches all allowed products for a member.
     *
     * @param   array  $params
     *
     * @return  \KoursesPhp\PaginatedCollection
     */
    public function all($params = null)
    {
        $this->validate($params);

        // Get member identificator
        $member = $params['member'];

        // Remove member key from params
        unset($params['member']);

        $response = $this->request('get', 'v1/members/' . $member . '/products', $params);

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

    /**
     * Validate required params.
     *
     * @param   array  $params
     *
     * @throws  InvalidArgumentException if required params are not set or if they are empty
     *
     * @return  bool
     */
    protected function validate($params)
    {
        if ( ! isset($params['member']) || empty($params['member'])) {
            throw new InvalidArgumentException('"member" param is required.');
        }

        return true;
    }
}