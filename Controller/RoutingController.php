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
use Genemu\Bundle\DoctrineExtraBundle\Entity\Pattern;
use Genemu\Bundle\DoctrineExtraBundle\Form\Type\RoutingType;

class RoutingController extends Controller
{
    public function indexAction($page = 1)
    {
        return array(
            'routings' => $this->getRepository()->findRoutingAll(false)
        );
    }

    public function editAction($id)
    {
        $routing = $this->getRouting($id);

        return $this->proccessForm($routing);
    }

    public function newAction()
    {
        $routing = new Routing();
        $routing->addPattern(new Pattern());

        return $this->proccessForm($routing);
    }

    public function moveAction($id, $type)
    {
        $routing = $this->getRouting($id);

        if ($type == 'up') {
            $this->getRepository()->moveUp($routing);
        } elseif ($type == 'down') {
            $this->getRepository()->moveDown($routing);
        }

        $this->getEm()->flush();

        return $this->redirect($this->generateUrl('routing_index'));
    }

    public function publishAction($id)
    {
        $routing = $this->getRouting($id);

        $routing->tooglePublish();
        $this->getEm()->flush();

        return $this->redirect($this->generateUrl('routing_index'));
    }

    public function removeAction($id)
    {
        $routing = $this->getRouting($id);

        $this->getEm()->remove($routing);
        $this->getEm()->flush();

        return $this->redirect($this->generateUrl('routing_index'));
    }

    protected function getEm()
    {
        return $this->getDoctrine()->getEntityManager();
    }

    protected function getRepository()
    {
        return $this->getDoctrine()->getRepository('GenemuDoctrineExtraBundle:Routing');
    }

    protected function getRouting($id)
    {
        $routing = $this->getRepository()->findOneById($id);

        if (!$routing) {
            $this->createNotFoundException();
        }

        return $routing;
    }

    protected function proccessForm(Routing $routing)
    {
        $form = $this->createForm(new RoutingType(), $routing);
        $request = $this->getRequest();

        if ($request->getMethod() == 'POST') {
            $form->bindRequest($request);

            if ($form->isValid()) {
                foreach ($routing->getPatterns() as $pattern) {
                    $routing->addPattern($pattern);
                }

                foreach ($routing->getParameters() as $parameter) {
                    $routing->addParameter($parameter);
                }

                $this->getEm()->flush();

                return $this->redirect($this->generateUrl('routing_index'));
            }
        }

        return array('form' => $form->createView());
    }
}
