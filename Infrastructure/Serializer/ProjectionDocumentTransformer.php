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
    private $context;

    public function __construct(NormalizerInterface $normalizer, ?string $format = null, array $context = [])
    {
        $this->normalizer = $normalizer;
        $this->format = $format;
        $this->context = $context;
    }

    public function __invoke(object $object): array
    {
        /** @var array */
        return $this->normalizer->normalize($object, $this->format, $this->context);
    }
}
