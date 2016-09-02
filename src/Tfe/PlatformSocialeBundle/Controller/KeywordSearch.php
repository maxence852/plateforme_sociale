<?php
/**
 * Created by PhpStorm.
 * User: maxence
 * Date: 02/09/2016
 * Time: 18:00
 */

namespace Tfe\PlatformSocialeBundle\Controller;


class KeywordSearch
{
    private $keywords;

    /**
     * @return mixed
     */
    public function getKeywords()
    {
        return $this->keywords;
    }

    /**
     * @param mixed $keywords
     */
    public function setKeywords($keywords)
    {
        $this->keywords = $keywords;
    }

    public function getKeywordsArray()
    {
        return explode(' ', $this->keywords);

    }

    public function getNbKeywords()
    {
        return str_word_count($this->keywords);
    }

}