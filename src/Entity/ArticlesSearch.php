<?php
/**
 * Created by PhpStorm.
 * User: cypriennkeneng
 * Date: 2019-02-12
 * Time: 22:05
 */

namespace App\Entity;


class ArticlesSearch
{
    /**
     * @var string|null
     */
    private $user;
    /**
     * @var string|null
     */
    private $category;

    /**
     * @return string|null
     */
    public function getCategory(): ?string
    {
        return $this->category;
    }

    /**
     * @param string|null $category
     * @return ArticlesSearch
     */
    public function setCategory(?string $category): ArticlesSearch
    {
        $this->category = $category;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getUser(): ?string
    {
        return $this->user;
    }

    /**
     * @param string|null $user
     * @return ArticlesSearch
     */
    public function setUser(?string $user): ArticlesSearch
    {
        $this->user = $user;
        return $this;
    }

}