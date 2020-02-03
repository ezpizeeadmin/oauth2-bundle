<?php

declare(strict_types=1);

namespace Ezpizee\Bundle\OAuth2Bundle;

use Doctrine\Bundle\DoctrineBundle\DependencyInjection\Compiler\DoctrineOrmMappingsPass;
use Ezpizee\Bundle\OAuth2Bundle\DependencyInjection\EzpizeeOAuth2Extension;
use Ezpizee\Bundle\OAuth2Bundle\DependencyInjection\Security\OAuth2Factory;
use Symfony\Bundle\SecurityBundle\DependencyInjection\SecurityExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

final class EzpizeeOAuth2Bundle extends Bundle
{
    /**
     * {@inheritdoc}
     */
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $this->configureDoctrineExtension($container);
        $this->configureSecurityExtension($container);
    }

    /**
     * {@inheritdoc}
     */
    public function getContainerExtension()
    {
        return new EzpizeeOAuth2Extension();
    }

    private function configureSecurityExtension(ContainerBuilder $container): void
    {
        /** @var SecurityExtension $extension */
        $extension = $container->getExtension('security');
        $extension->addSecurityListenerFactory(new OAuth2Factory());
    }

    private function configureDoctrineExtension(ContainerBuilder $container): void
    {
        $container->addCompilerPass(
            DoctrineOrmMappingsPass::createXmlMappingDriver(
                [
                    realpath(__DIR__ . '/Resources/config/doctrine/model') => 'Ezpizee\Bundle\OAuth2Bundle\Model',
                ],
                [
                    'ezpizee.oauth2.persistence.doctrine.manager',
                ],
                'ezpizee.oauth2.persistence.doctrine.enabled',
                [
                    'EzpizeeOAuth2Bundle' => 'Ezpizee\Bundle\OAuth2Bundle\Model',
                ]
            )
        );
    }
}
