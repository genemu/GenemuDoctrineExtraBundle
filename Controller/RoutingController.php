<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Olivier Chauvel <olchauvel@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Genemu\Bundle\DoctrineExtraBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Genemu\Bundle\DoctrineExtraBundle\Entity\Routing;
use Genemu\Bundle\DoctrineExtraBundle\Form\Type\RoutingType;

class RoutingController extends Controller
{
    public function indexAction()
    {
        return array(
            'routings' => $this->getDoctrine()->getRepository('GenemuDoctrineExtraBundle:Routing')->findRoutingAll(false)
        );
    }

    public function editAction(Routing $routing)
    {
        if (true === $form = $this->proccessForm($routing)) {
            return $this->redirect($this->generateUrl('routing_index'));
        }

        return array('form' => $form);
    }

    public function newAction()
    {
        $routing = new Routing();

        if (true === $form = $this->proccessForm($routing)) {
            return $this->redirect($this->generateUrl('routing_index'));
        }

        return array('form' => $form);
    }

    public function moveAction(Routing $routing, $type)
    {
        $repository = $this->getDoctrine()->getRepository('GenemuDoctrineExtraBundle:Routing');

        if ($type == 'up') {
            $repository->moveUp($routing);
        } elseif ($type == 'down') {
            $repository->moveDown($routing);
        }

        $this->getEm()->flush();

        return $this->redirect($this->generateUrl('routing_index'));
    }

    public function publishAction(Routing $routing)
    {
        $routing->tooglePublish();
        $this->getEm()->flush();

        return $this->redirect($this->generateUrl('routing_index'));
    }

    public function removeAction(Routing $routing)
    {
        $this->getEm()->remove($routing);
        $this->getEm()->flush();

        return $this->redirect($this->generateUrl('routing_index'));
    }

    protected function getEm()
    {
        return $this->getDoctrine()->getEntityManager();
    }

    protected function proccessForm(Routing $routing)
    {
        $form = $this->createForm(new RoutingType(), $routing);
        $request = $this->getRequest();

        if ($request->getMethod() == 'POST') {
            $form->bindRequest($request);

            if ($form->isValid()) {
                foreach ($routing->getPatterns() as $pattern) {
                    $pattern->setRouting($routing);
                }
                $this->getEm()->persist($routing);
                $this->getEm()->flush();

                return true;
            }
        }

        return $form->createView();
    }
}
