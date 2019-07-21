<?php

declare(strict_types=1);

namespace MsgPhp\Domain\Projection;

/**
 * @author Roland Franssen <franssen.roland@gmail.com>
 */
final class ProjectionTypeResolver
{
    /** @var array<class-string, string> */
    private $classLookup;

    /**
     * @param array<class-string, string> $classLookup
     */
    public function __construct(array $classLookup)
    {
        $this->classLookup = $classLookup;
    }

    public function __invoke(object $object): string
    {
        if (isset($this->classLookup[$class = \get_class($object)])) {
            return $this->classLookup[$class];
        }

        foreach ($this->classLookup as $class => $type) {
            if ($object instanceof $class) {
                return $this->classLookup[$class] = $type;
            }
        }

        throw new \LogicException('Cannot get document type for class "'.$class.'".');
    }
}
