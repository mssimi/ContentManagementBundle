<?php
declare(strict_types = 1);

namespace mssimi\ContentManagementBundle\Document;

use Doctrine\ODM\PHPCR\Mapping\Annotations as PHPCR;
use Doctrine\ODM\PHPCR\ReferenceManyCollection;

/**
 * @PHPCR\Document(repositoryClass="mssimi\ContentManagementBundle\Repository\GalleryRepository")
 */
class Gallery extends AbstractPage
{
    /**
     *
     * @PHPCR\ReferenceMany(strategy="hard", targetDocument="GalleryImage", cascade={"persist", "remove"})
     */
    private $images;

    /**
     * @return mixed
     */
    public function getImages()
    {
        return $this->images;
    }


    /**
     * @param $images
     */
    public function setImages($images)
    {
        $this->images = $images;
    }
}