<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Olivier Chauvel <olchauvel@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Genemu\Bundle\DoctrineExtraBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Finder\Finder;
use Genemu\Bundle\DoctrineExtraBundle\Entity\Bundle;
use Genemu\Bundle\DoctrineExtraBundle\Entity\Controller;
use Genemu\Bundle\DoctrineExtraBundle\Entity\Method;
use Genemu\Bundle\DoctrineExtraBundle\Entity\View;

/**
 * @author Olivier Chauvel <olchauvel@gmail.com>
 */
class UpdateCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('router:fixtures:update')
            ->setDescription('Update Bundles, controllers and views to bundles');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $container = $this->getContainer();
        $bundles = array();
        if ($container->hasParameter('kernel.bundles')) {
            $bundles = $container->getParameter('kernel.bundles');
        }

        $this->em = $container->get('doctrine')->getEntityManager();

        $updated = $this->updateBundle(
            $this->searchBundle($bundles),
            $this->em->getRepository('GenemuDoctrineExtraBundle:Bundle')->findAllByUpdate(),
            $output
        );

        if (!$updated) {
            $output->writeln('<info>Nothing changements</info>');
        } else {
            $this->em->flush();
        }
    }

    protected function searchBundle(array $bundles)
    {
        $fBundles = array();
        foreach ($bundles as $bundleName => $class) {
            $class = new $class();

            $controllers = array();
            if ($dir = realpath($class->getPath().'/Controller')) {
                $files = new Finder();
                $files->files()->name('*Controller.php')->in($dir);

                foreach ($files as $file) {
                    if ('Controller.php' != $controllerName = $file->getBasename('Controller.php')) {
                        $ns = $class->getNamespace().'\\Controller';

                        if ($relativePath = $file->getRelativePath()) {
                            $ns .= '\\'.strtr($relativePath, array('/' => '\\'));
                        }

                        $reflection = new \ReflectionClass($ns.'\\'.$file->getBasename('.php'));

                        $methods = array();
                        foreach ($reflection->getMethods(\ReflectionMethod::IS_PUBLIC) as $method) {
                            if (preg_match('/^(.+)Action$/', $method->getName(), $matchAction)) {
                                $methods[$matchAction[1]] = true;
                            }
                        }

                        $parent = $reflection->getParentClass();
                        if ($parent) {
                            foreach ($parent->getMethods(\ReflectionMethod::IS_PUBLIC) as $method) {
                                if (preg_match('/Action/', $method->getName())) {
                                    $methods[strtr($method->getName(), array('Action' => ''))] = true;
                                }
                            }
                        }
                        $controllers[$controllerName] = array(
                            'methods' => $methods
                        );
                    }
                }
            }

            $views = array();
            if ($dir = realpath($class->getPath().'/Resources/views')) {
                $files = new Finder();
                $files->files()->in($dir);

                foreach ($files as $file) {
                    $views[$file->getRelativePath().':'.$file->getBasename()] = true;
                }
            }

            $fBundles[$bundleName] = array(
                'controllers' => $controllers,
                'views' => $views
            );
        }

        return $fBundles;
    }

    protected function updateBundle(array $files, array $bundles, OutputInterface $output)
    {
        $updated = false;

        foreach ($files as $bundleName => $bundleValues) {
            if (isset($bundles[$bundleName])) {
                $bundle = $bundles[$bundleName];
                foreach ($bundleValues['controllers'] as $controllerName => $controllerValues) {
                    if (isset($bundle['controllers'][$controllerName])) {
                        $controller = $bundle['controllers'][$controllerName];
                        foreach ($controllerValues['methods'] as $methodName => $methodValues) {
                            if (isset($controller['methods'][$methodName])) {
                                unset($controller['methods'][$methodName]);
                            } else {
                                $updated = true;
                                $this->createMethod($output, $methodName, $controller['entity']);
                            }
                        }

                        foreach ($controller['methods'] as $name => $values) {
                            $update = true;
                            $output->writeln('<info>Remove method '.$name.' in '.$controllerName.'</info>');
                            $this->em->remove($values['entity']);
                        }

                        unset($bundle['controllers'][$controllerName]);
                    } else {
                        $updated = true;
                        $this->createController($output, $controllerName, $bundle['entity'], $controllerValues['methods']);
                    }
                }

                foreach ($bundle['controllers'] as $name => $values) {
                    $updated = true;
                    $output->writeln('<info>Remove controller '.$name.' in '.$bundleName.'</info>');
                    $this->em->remove($values['entity']);
                }

                foreach ($bundleValues['views'] as $viewName => $viewValues) {
                    if (isset($bundle['views'][$viewName])) {
                        unset($bundle['views'][$viewName]);
                    } else {
                        $updated = true;
                        $this->createView($output, $viewName, $bundle['entity']);
                    }
                }

                foreach ($bundle['views'] as $name => $values) {
                    $updated = true;
                    $output->writeln('<info>Remove view '.$name.' in '.$bundleName.'</info>');
                    $this->em->remove($values['entity']);
                }

                unset($bundles[$bundleName]);
            } else {
                $updated = true;
                $bundle = $this->createBundle($output, $bundleName, $bundleValues['controllers']);

                foreach ($bundleValues['views'] as $viewName => $viewValues) {
                    $this->createView($output, $viewName, $bundle);
                }
            }
        }

        foreach ($bundles as $name => $values) {
            $updated = true;
            $output->writeln('<info>Remove bundle '.$name.'</info>');
            $this->em->remove($values['entity']);
        }

        return $updated;
    }

    /**
     * Create bundle
     *
     * @param OutputInterface $output
     * @param string          $name
     * @param array           $controllers
     *
     * @return Bundle $bundle
     */
    protected function createBundle(OutputInterface $output, $name, array $controllers)
    {
        $bundle = new Bundle();
        $bundle->setName($name);
        $this->em->persist($bundle);

        $output->writeln('<info>Create bundle '.$name.'</info>');

        foreach ($controllers as $name => $values) {
            $this->createController($output, $name, $bundle, $values['methods']);
        }

        return $bundle;
    }

    /**
     * Create controller
     *
     * @param OutputInterface $output
     * @param string          $name
     * @param Bundle          $bundle
     * @param array           $methods
     *
     * @return Controller $controller
     */
    protected function createController(OutputInterface $output, $name, Bundle $bundle, array $methods)
    {
        $controller = new Controller();
        $controller->setName($name);
        $controller->setBundle($bundle);
        $this->em->persist($controller);

        $output->writeln('<info>Create controller '.$name.' in '.$bundle->getName().'</info>');

        foreach ($methods as $name => $values) {
            $this->createMethod($output, $name, $controller);
        }

        return $controller;
    }

    /**
     * Create method
     *
     * @param OutputInterface $output
     * @param string          $name
     * @param Controller      $controller
     *
     * @return Method $method
     */
    protected function createMethod(OutputInterface $output, $name, Controller $controller)
    {
        $method = new Method();
        $method->setName($name);
        $method->setController($controller);
        $this->em->persist($method);

        $output->writeln('<info>Ctreate method '.$name.' in '.$controller->getName().'</info>');

        return $method;
    }

    /**
     * Create view
     *
     * @param OutputInterface $output
     * @param string          $name
     * @param Bundle          $bundle
     *
     * @return View $view
     */
    protected function createView(OutputInterface $output, $name, Bundle $bundle)
    {
        list($directory, $file) = explode(':', $name);
        list($name, $format, $engine) = explode('.', $file);

        $view = new View();
        $view->setBundle($bundle);
        $view->setDirectory($directory);
        $view->setName($name);
        $view->setFormat($format);
        $view->setEngine($engine);
        $this->em->persist($view);

        $output->writeln('<info>Create view '.$file.' in '.$bundle->getName().'</info>');

        return $view;
    }
}
