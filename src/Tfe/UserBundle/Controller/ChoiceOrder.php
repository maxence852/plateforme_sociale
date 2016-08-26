<?php
/**
 * Created by PhpStorm.
 * User: maxence
 * Date: 26/08/2016
 * Time: 19:11
 */

namespace Tfe\UserBundle\Controller;


class ChoiceOrder
{

    protected $orderBy;

    public function setOrderBy($orderBy)
    {
        $this->orderBy = $orderBy;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getOrderBy()
    {
        return $this->orderBy;
    }
}