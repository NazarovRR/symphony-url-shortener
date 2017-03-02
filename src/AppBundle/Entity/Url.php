<?php
/**
 * Created by PhpStorm.
 * User: mikhailnazarov
 * Date: 01.03.17
 * Time: 11:08
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use AppBundle\Validator\Constraints as AppAssert;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UrlRepository")
 * @ORM\Table(name="url")
 */
class Url
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;
    /**
     * @ORM\Column(type="text")
     * @AppAssert\IsValidUrl()
     */
    private $full_url;
    /**
     * @ORM\Column(type="string", nullable=TRUE)
     * @Assert\Type(type="alnum", message="The value of Short url can contain only numbers and letters")
     * @Assert\Length(
     *  min = 3,
     *  max = 10,
     *  minMessage="Short url must be at least {{ limit }} characters length",
     *  maxMessage="Short url cannot be longer than {{ limit }} characters"
     * )
     * @AppAssert\ModelExist()
     */
    private $encoded;

    /**
     * @return mixed
     */
    public function getFullUrl()
    {
        return $this->full_url;
    }

    /**
     * @param mixed $full_url
     */
    public function setFullUrl($full_url)
    {
        $this->full_url = $full_url;
    }

    /**
     * @return mixed
     */
    public function getEncoded()
    {
        return $this->encoded;
    }

    /**
     * @param mixed $encoded
     */
    public function setEncoded($encoded)
    {
        $this->encoded = $encoded;
    }



    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }
}
