<?php

namespace Sitioweb\Bundle\ApiBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class CreateClientCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('fos:oauth-server:client:create')
            ->setDescription('Creates a new client')
            ->addArgument('name', InputArgument::REQUIRED, 'The client name')
            ->addOption(
                'redirect-uri',
                null,
                InputOption::VALUE_REQUIRED | InputOption::VALUE_IS_ARRAY,
                'Sets redirect uri for client. Use this option multiple times to set multiple redirect URIs.',
                null
            )
            ->addOption(
                'grant-type',
                null,
                InputOption::VALUE_REQUIRED | InputOption::VALUE_IS_ARRAY,
                'Sets allowed grant type for client. Use this option multiple times to set multiple grant types..',
                null
            )
            ->setHelp(
                <<<EOT
                    The <info>%command.name%</info>command creates a new client.

<info>php %command.full_name% [--redirect-uri=...] [--grant-type=...] name</info>

EOT
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $clientManager = $this->getContainer()->get('fos_oauth_server.client_manager.default');
        $client = $clientManager->createClient();
        $client->setRedirectUris($input->getOption('redirect-uri'));
        $client->setAllowedGrantTypes($input->getOption('grant-type'));
        $client->setName($input->getArgument('name'));
        $clientManager->updateClient($client);
        $output->writeln(
            sprintf(
                'Added a new client <info>%s</info> with public id <info>%s</info> , secret <info>%s</info>',
                $client->getName(),
                $client->getPublicId(),
                $client->getSecret()
            )
        );
    }
}
