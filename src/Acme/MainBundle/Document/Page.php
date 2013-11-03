<?php

namespace Acme\MainBundle\Document;

use Doctrine\ODM\PHPCR\Mapping\Annotations as PHPCR;
use Symfony\Cmf\Bundle\ContentBundle\Doctrine\Phpcr\StaticContent;

/**
 * @PHPCR\Document(
 *  referenceable=true,
 *  mixins={"mix:created", "mix:lastModified"}
 * )
 */
class Page extends StaticContent
{
    /** @PHPCR\Date(property="jcr:created") */
    protected $createdAt;

    /** @PHPCR\Date(property="jcr:lastModified") */
    protected $updatedAt;

    /**
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }
}