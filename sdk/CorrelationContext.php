<?php

declare(strict_types=1);

namespace OpenTelemetry\Sdk;

use OpenTelemetry\Context\Context;
use OpenTelemetry\Context\ContextKey;

class CorrelationContext
{
    use Context;

    /**
     * @param CorrelationContext $context
     */
    public function getCorrelations($context = null)
    {
        // TODO: Write me
    }

    /**
     * @param ContextKey $key
     *
     * @return CorrelationContext
     */
    public function removeCorrelation(ContextKey $key): CorrelationContext
    {
        if ($this->key === $key) {
            return $this->parent;
        }

        $this->removeCorrelationHelper($key, null);

        return $this;
    }

    /**
     * @param ContextKey $key
     * @param CorrelationContext|null $child
     * @suppress PhanUndeclaredMethod
     * @suppress PhanTypeMismatchArgument
     */
    private function removeCorrelationHelper(ContextKey $key, ?CorrelationContext $child)
    {
        if ($this->key !== $key) {
            if (null === $this->parent) {
                return;
            }
            $this->parent->removeCorrelationHelper($key, $this);

            return;
        }

        $child->setParent($this->parent);
    }

    /**
     * @param CorrelationContext $parent
     *
     * @return null
     */
    public function setParent(CorrelationContext $parent)
    {
        $this->parent = $parent;
    }

    /**
     * When called on a CorrelationContext, this function will destroy all Correlation data
     *
     * @return null
     */
    public function clearCorrelations()
    {
        $cur_node = $this;
        do {
            echo "looping" . PHP_EOL;
            $cur_node->key = null;
            $cur_node->value = null;
            $cur_node = $cur_node->parent;
        } while (null !== $cur_node->parent);
    }
}
