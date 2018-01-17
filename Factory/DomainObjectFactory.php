<?php

declare(strict_types=1);

namespace MsgPhp\Domain\Factory;

use MsgPhp\Domain\{DomainIdInterface, DomainCollectionInterface};
use MsgPhp\Domain\Exception\InvalidClassException;

/**
 * @author Roland Franssen <franssen.roland@gmail.com>
 */
final class DomainObjectFactory implements DomainObjectFactoryInterface
{
    private static $reflectionCache = [];

    private $factory;

    public function setNestedFactory(?DomainObjectFactoryInterface $factory): void
    {
        $this->factory = $factory;
    }

    public function create(string $class, array $context = [])
    {
        if (!class_exists($class)) {
            throw InvalidClassException::create($class);
        }

        if (is_subclass_of($class, DomainIdInterface::class) || is_subclass_of($class, DomainCollectionInterface::class)) {
            return $class::fromValue(...$this->resolveArguments($class, $context, 'fromValue'));
        }

        return new $class(...$this->resolveArguments($class, $context));
    }

    private function resolveArguments(string $class, array $context, string $method = '__construct'): array
    {
        if (!isset(self::$reflectionCache[$cacheKey = $class.'::'.$method])) {
            $reflection = new \ReflectionClass($class);
            if ('__construct' === $method) {
                if (null === $method = $reflection->getConstructor()) {
                    return self::$reflectionCache[$cacheKey] = [];
                }
            } elseif (!($method = $reflection->getMethod($method))->isStatic() || !$method->isPublic()) {
                throw new \LogicException(sprintf('To factorize object "%s" the method "%s" must be static and public.', $class, $method->getName()));
            }

            self::$reflectionCache[$cacheKey] = array_map(function (\ReflectionParameter $param): array {
                return [
                    strtolower(preg_replace(array('/([A-Z]+)([A-Z][a-z])/', '/([a-z\d])([A-Z])/'), array('\\1_\\2', '\\1_\\2'), $param->getName())),
                    $param->isDefaultValueAvailable() || $param->allowsNull(),
                    $param->isDefaultValueAvailable() ? $param->getDefaultValue() : null,
                    null !== ($type = $param->getType()) && !$type->isBuiltin()
                        ? ('self' === strtolower($name = $type->getName())
                            ? $param->getClass()->getName()
                            : $name)
                        : null,
                ];
            }, $method->getParameters());
        }

        $arguments = [];

        foreach (self::$reflectionCache[$cacheKey] as $i => $argument) {
            list($key, $hasDefault, $default, $type) = $argument;

            if (array_key_exists($key, $context)) {
                $value = $context[$key];
                $hasContext = true;
            } elseif (array_key_exists($i, $context)) {
                $value = $context[$i];
                $hasContext = true;
            } else {
                $value = $default;
                $hasContext = false;
            }

            if (!$hasContext && !$hasDefault) {
                throw new \LogicException(sprintf('No value available for constructor argument #%d in class "%s".', $i, $class));
            }

            if (null !== $type && $hasContext && !is_object($value)) {
                try {
                    $arguments[] = ($this->factory ?? $this)->create($type, (array) $value);

                    continue;
                } catch (InvalidClassException $e) {
                }
            }

            $arguments[] = $value;
        }

        return $arguments;
    }
}
