<?php

namespace spec\GrumPHP\Configuration;

use GrumPHP\Collection\TestSuiteCollection;
use GrumPHP\Configuration\GrumPHP;
use GrumPHP\Exception\RuntimeException;
use PhpSpec\ObjectBehavior;
use Symfony\Component\DependencyInjection\ContainerInterface;

class GrumPHPSpec extends ObjectBehavior
{
    function let(ContainerInterface $container)
    {
        $this->beConstructedWith($container);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(GrumPHP::class);
    }

    function it_knows_the_hooks_dir(ContainerInterface $container)
    {
        $container->getParameter('hooks_dir')->willReturn('./hooks/');
        $this->getHooksDir()->shouldReturn('./hooks/');
    }

    function it_knows_the_hooks_preset(ContainerInterface $container)
    {
        $container->getParameter('hooks_preset')->willReturn('local');
        $this->getHooksPreset()->shouldReturn('local');
    }

    function it_knows_the_git_hook_variables(ContainerInterface $container)
    {
        $data = [
            'VAGRANT_HOST_DIR' => '.',
            'VAGRANT_PROJECT_DIR' => '/var/www',
            'EXEC_GRUMPHP_COMMAND' => 'exec'
        ];
        $container->getParameter('git_hook_variables')->willReturn($data);
        $this->getGitHookVariables()->shouldReturn($data);
    }

    function it_knows_to_stop_on_failure(ContainerInterface $container)
    {
        $container->getParameter('stop_on_failure')->willReturn(true);
        $this->stopOnFailure()->shouldReturn(true);
    }

    function it_knows_to_ignore_unstaged_changes(ContainerInterface $container)
    {
        $container->getParameter('ignore_unstaged_changes')->willReturn(true);
        $this->ignoreUnstagedChanges()->shouldReturn(true);
    }

    function it_configures_the_process_async_limit(ContainerInterface $container)
    {
        $container->getParameter('process_async_limit')->willReturn(5);
        $this->getProcessAsyncLimit()->shouldReturn(5);
    }

    function it_configures_the_process_async_wait_time(ContainerInterface $container)
    {
        $container->getParameter('process_async_wait')->willReturn(0);
        $this->getProcessAsyncWaitTime()->shouldReturn(0);
    }

    function it_configures_the_symfony_process_timeout(ContainerInterface $container)
    {
        $container->getParameter('process_timeout')->willReturn(null);
        $this->getProcessTimeout()->shouldReturn(null);

        $container->getParameter('process_timeout')->willReturn(120);
        $this->getProcessTimeout()->shouldReturn(120.0);
    }

    function it_should_return_empty_ascii_location_for_unknown_resources(ContainerInterface $container)
    {
        $container->getParameter('ascii')->willReturn([]);
        $this->getAsciiContentPath('success')->shouldReturn(null);
    }

    function it_should_return_the_ascii_location_for_known_resources(ContainerInterface $container)
    {
        $container->getParameter('ascii')->willReturn(['success' => 'success']);
        $this->getAsciiContentPath('success')->shouldReturn('success');
    }

    function it_should_return_the_ascii_location_from_list(ContainerInterface $container)
    {
        $container->getParameter('ascii')->willReturn(['success' => ['success.txt']]);
        $this->getAsciiContentPath('success')->shouldReturn('success.txt');
    }

    function it_should_know_all_testsuites(ContainerInterface $container)
    {
        $container->getParameter('grumphp.testsuites')->willReturn($testSuites = new TestSuiteCollection());
        $this->getTestSuites()->shouldBe($testSuites);
    }

    function it_knows_the_additional_info(ContainerInterface $container)
    {
        $container->getParameter('additional_info')
            ->willReturn('https://docs.example.com');

        $this->getAdditionalInfo()->shouldReturn('https://docs.example.com');
    }
}
