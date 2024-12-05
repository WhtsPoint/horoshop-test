<?php

namespace App\Serializer;

use App\ValueObject\UserProperty;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class UserPropertyNormalizer implements NormalizerInterface
{
    /** @param UserProperty $data */
    public function normalize(mixed $data, ?string $format = null, array $context = []): array|string|int|float|bool|\ArrayObject|null
    {
        return $data->getValue();
    }

    public function supportsNormalization(mixed $data, ?string $format = null, array $context = []): bool
    {
        return $data instanceof UserProperty;
    }

    public function getSupportedTypes(?string $format): array
    {
        return [UserProperty::class => true];
    }
}