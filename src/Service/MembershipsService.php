<?php

namespace KoursesPhp\Service;

use KoursesPhp\Membership;
use KoursesPhp\PaginationMetadata;
use KoursesPhp\PaginatedCollection;

class MembershipsService extends AbstractService
{
    /**
     * Returns a paginated collection list with all memberships.
     *
     * @param   array  $params
     *
     * @return  \KoursesPhp\PaginatedCollection
     */
    public function all($params = null)
    {
        $response = $this->request('get', 'v1/memberships', $params);

        $memberships = [];

        if (is_array($response['data']) && count($response['data'])) {
            $memberships = array_map(function ($item) {
                return new Membership($item);
            }, $response['data']);
        }

        $collection = new PaginatedCollection($memberships);

        if (isset($response['meta'])) {
            $collection->setPaginationMetadata(new PaginationMetadata($response['meta']));
        }

        return $collection;
    }
}
