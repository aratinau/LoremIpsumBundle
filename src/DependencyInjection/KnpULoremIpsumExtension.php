<?php


namespace KnpU\LoremIpsumBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

class KnpULoremIpsumExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.xml');

        $configuration = $this->getConfiguration($configs, $container);
        $config = $this->processConfiguration($configuration, $configs);

        $definition = $container->getDefinition('knpu_lorem_ipsum.knpu_ipsum');
        if (null !== $config['word_provider']) {
            // $definition->setArgument(0, new Reference($config['word_provider']));
            /*
             * Reference()
             * when we set the argument to $config['word_provider'],
             * this of course sets that argument to the string value!
             * To fix this in YAML, we would prefix the service id with
             * the @ symbol. In PHP, wrap the value in a new Reference() object.
             * This tells Symfony that we're referring to a service.
             *
             * */

            $container->setAlias('knpu_lorem_ipsum.word_provider', $config['word_provider']);
            // php bin/console debug:container --show-private knpu_lorem_ipsum.word_provider
        }
        $definition->setArgument(1, $config['unicorns_are_real']);
        $definition->setArgument(2, $config['min_sunshine']);
    }

    public function getAlias()
    {
        return 'knpu_lorem_ipsum';
    }

}
