<?php

namespace Meromn\UseCaseGenerator\DependencyInjection;

use Meromn\UseCaseGenerator\Service\UseCaseGeneratorService;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

class MeromnUseCaseGeneratorExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new YamlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.yaml');

        if (!isset($configs[0]['folder_location'])) {
            $configs[0]['folder_location'] = '%kernel.project_dir%/src/UseCase';
        }
        if (!isset($configs[0]['folder_test_location'])) {
            $configs[0]['folder_test_location'] = '%kernel.project_dir%/tests/UseCase';
        }
        if (!isset($configs[0]['naming']['use_case'])) {
            $configs[0]['naming']['use_case'] = 'UseCase';
        }
        if (!isset($configs[0]['naming']['request'])) {
            $configs[0]['naming']['request'] = 'Request';
        }
        if (!isset($configs[0]['naming']['response'])) {
            $configs[0]['naming']['response'] = 'Response';
        }
        if (!isset($configs[0]['namespace_for_use_case'])) {
            $configs[0]['namespace_for_use_case'] = 'App\UseCase';
        }
        if (!isset($configs[0]['namespace_for_tests_use_case'])) {
            $configs[0]['namespace_for_tests_use_case'] = 'App\Tests\UseCase';
        }
        $definition = $container->getDefinition(UseCaseGeneratorService::class);
        $definition->replaceArgument(0, $configs[0]['folder_location'])
            ->replaceArgument(1, $configs[0]['folder_test_location'])
            ->replaceArgument(2, $configs[0]['naming']['use_case'])
            ->replaceArgument(3, $configs[0]['naming']['request'])
            ->replaceArgument(4, $configs[0]['naming']['response'])
            ->replaceArgument(5, $configs[0]['namespace_for_use_case'])
            ->replaceArgument(6, $configs[0]['namespace_for_tests_use_case']);
    }

    public function getAlias(): string
    {
        return 'use_case_maker';
    }
}