<?php

namespace Meromn\UseCaseGenerator;

use Meromn\UseCaseGenerator\DependencyInjection\MeromnUseCaseGeneratorExtension;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class MeromnUseCaseGeneratorBundle extends Bundle
{
    public function getContainerExtension(): ?ExtensionInterface
    {
        if (null === $this->extension) {
            $this->extension = new MeromnUseCaseGeneratorExtension();
        }
        return $this->extension;
    }
}