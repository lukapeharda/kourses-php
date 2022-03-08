<?php

namespace KoursesPhp\Service;

use KoursesPhp\Exception\InvalidArgumentException;

class PermissionsService extends AbstractService
{
    /**
     * Create permission for a member and a product.
     *
     * @param   array  $params
     *
     * @return  string
     */
    public function create($params)
    {
        $this->validate($params);

        // Get required params
        $member = $params['member'];
        $product = $params['product'];

        // Remove required params
        unset($params['member']);
        unset($params['product']);

        $response = $this->request('post', 'v1/members/' . $member . '/products/' . $product . '/permissions', $params);

        return $response['status'];
    }

    /**
     * Delete a permission for a member and a product.
     *
     * @param   array  $params
     *
     * @return  string
     */
    public function delete($params)
    {
        $this->validate($params);

        // Get required params
        $member = $params['member'];
        $product = $params['product'];

        // Remove required params
        unset($params['member']);
        unset($params['product']);

        $response = $this->request('delete', 'v1/members/' . $member . '/products/' . $product . '/permissions', $params);

        return $response['status'];
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

        if ( ! isset($params['product']) || empty($params['product'])) {
            throw new InvalidArgumentException('"product" param is required.');
        }

        return true;
    }
}
