<?php

declare(strict_types=1);

namespace MsgPhp\Domain\Infrastructure\Serializer;

use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

/**
 * @author Roland Franssen <franssen.roland@gmail.com>
 */
final class ProjectionDocumentTransformer
{
    private $normalizer;
    private $format;

    public function __construct(NormalizerInterface $normalizer, string $format = 'document')
    {
        $this->normalizer = $normalizer;
        $this->format = $format;
    }

    public function __invoke(object $object): array
    {
        /** @var array */
        return $this->normalizer->normalize($object, $this->format);
    }
}
