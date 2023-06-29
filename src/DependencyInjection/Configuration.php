<?php

namespace Meromn\UseCaseGenerator\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{

    /**
     * @inheritDoc
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder('use_case_maker');
        $rootNode = $treeBuilder->getRootNode();
        $rootNode->children()
            ->scalarNode('folder_location')->defaultValue('%kernel.project_dir%/src/UseCase')->info('Where the files will be create')->end()
            ->scalarNode('folder_test_location')->defaultValue('%kernel.project_dir%/tests/UseCase')->info('Where the tests files will be create')->end()
            ->scalarNode('namespace_for_use_case')->defaultValue('App\UseCase')->info('The namespace for class create')->end()
            ->scalarNode('namespace_for_tests_use_case')->defaultValue('App\Tests\UseCase')->info('The namespace for the test class created')->end()
            ->arrayNode('naming')
                ->children()
                    ->scalarNode('use_case')->info('The name of the use case class')->end()
                    ->scalarNode('request')->info('The name of the request class')->end()
                    ->scalarNode('response')->info('The name of the response class')->end()
                ->end()
            ->end()
        ->end();
        return $treeBuilder;
    }
}