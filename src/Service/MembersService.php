<?php

namespace Kourses\Service;

use Kourses\Member;

class MembersService extends AbstractService
{
    /**
     * Create a member on Kourses.
     *
     * @param   array  $params
     *
     * @return  \Kourses\Member
     */
    public function create($params)
    {
        $response = $this->request('post', 'v1/members', $params);

        return new Member($response['data']);
    }
}
