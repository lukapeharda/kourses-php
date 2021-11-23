<?php

namespace Kourses\Service;

use Kourses\LoginLink;
use Kourses\Exception\InvalidArgumentException;

class MemberLoginLinkService extends AbstractService
{
    /**
     * Generate login link for member.
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

        // Remove required params
        unset($params['member']);

        // Manually generate list of allowed params
        $allowedParams = [
            'redirect' => $params['redirect'] ?? null,
        ];

        $response = $this->request('post', 'v1/members/' . $member . '/login-link', $allowedParams);

        return new LoginLink($response['data']);
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
