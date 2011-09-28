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
        return array(
            'form' => $this->proccessForm($routing)
        );
    }

    public function newAction()
    {
        $routing = new Routing();

        return array(
            'form' => $this->proccessForm($routing)
        );
    }

    public function publishAction(Routing $routing)
    {
        $routing->tooglePublish();
        $this->getDoctrine()->getEntityManager()->flush();

        return $this->redirect($this->generateUrl('routing_index'));
    }

    public function removeAction(Routing $routing)
    {
        $this->getDoctrine()->getEntityManager()->remove($routing);
        $this->getDoctrine()->getEntityManager()->flush();

        return $this->redirect($this->generateUrl('routing_index'));
    }

    protected function proccessForm(Routing $routing)
    {
        $form = $this->createForm(new RoutingType(), $routing);
        $request = $this->getRequest();

        if ($request->getMethod() == 'POST') {
            $form->bindRequest($request);

            if ($form->isValid()) {
                $this->getDoctrine()->getEntityManager()->persist($routing);
                $this->getDoctrine()->getEntityManager()->flush();
            }
        }

        return $form->createView();
    }
}
