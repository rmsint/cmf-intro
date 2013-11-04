<?php

namespace Acme\MainBundle\PublishWorkflow\Voter;

use Symfony\Cmf\Bundle\CoreBundle\PublishWorkflow\PublishWorkflowChecker;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\VoterInterface;
use Symfony\Cmf\Bundle\CoreBundle\PublishWorkflow\PublishableReadInterface;

/**
 * Workflow voter to check if the content of a menu node is published.
 */
class MenuContentVoter implements VoterInterface
{
    /**
     * {@inheritdoc}
     */
    public function supportsAttribute($attribute)
    {
        return PublishWorkflowChecker::VIEW_ATTRIBUTE === $attribute
            || PublishWorkflowChecker::VIEW_ANONYMOUS_ATTRIBUTE === $attribute
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function supportsClass($class)
    {
        return is_subclass_of($class, 'Symfony\Cmf\Bundle\MenuBundle\Model\MenuNode');
    }

    /**
     * {@inheritdoc}
     *
     * @param MenuNode $object
     */
    public function vote(TokenInterface $token, $object, array $attributes)
    {
        if (!$this->supportsClass(get_class($object))) {
            return self::ACCESS_ABSTAIN;
        }

        $decision = self::ACCESS_GRANTED;
        foreach ($attributes as $attribute) {
            if (! $this->supportsAttribute($attribute)) {
                // there was an unsupported attribute in the request.
                // now we only abstain or deny if we find a supported attribute
                // and the content is not publishable
                $decision = self::ACCESS_ABSTAIN;
                continue;
            }
            $content = $object->getContent();
            if ($content && $content instanceof PublishableReadInterface && ! $content->isPublishable()) {
                return self::ACCESS_DENIED;
            }
        }

        return $decision;
    }
}
