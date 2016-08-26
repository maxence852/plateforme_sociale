<?php
/**
 * Created by PhpStorm.
 * User: maxence
 * Date: 26/08/2016
 * Time: 19:11
 */

namespace Tfe\UserBundle\Controller;


class SearchUser
{

    protected $searchUser;

    public function setSearchUser($searchUser)
    {
        $this->searchUser = $searchUser;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getSearchUser()
    {
        return $this->searchUser;
    }
}