<?php

namespace KoursesPhp;

/**
 * @property string $id
 * @property string $email
 * @property string $firstName
 * @property string $lastName
 * @property \KoursesPhp\Collection $memberships
 * @property string $status
 */
class Member extends DataTransferObject
{
    const STATUS_CREATED = 'created';
    const STATUS_UPDATED = 'updated';

    /**
     * Memberships accessor.
     *
     * @return  \KoursesPhp\Collection
     */
    public function getMembershipsAttribute()
    {
        return $this->convertMembershipsArrayToHydratedMembershipCollection();
    }

    /**
     * Convert member's memberships from array in data to a hydrated collection.
     *
     * @return  \KoursesPhp\Collection
     */
    protected function convertMembershipsArrayToHydratedMembershipCollection()
    {
        if ( ! isset($this->data['memberships']) || empty($this->data['memberships']) || count($this->data['memberships']) === 0) {
            return new Collection();
        }

        return (new Collection($this->data['memberships']))->map(function ($membership) {
            return new Membership($membership);
        });
    }
}
