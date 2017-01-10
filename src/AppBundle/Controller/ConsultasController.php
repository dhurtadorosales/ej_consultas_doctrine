<?php

namespace AppBundle\Controller;

use Doctrine\ORM\EntityManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ConsultasController extends Controller
{
    /**
     * @Route("/ej1", name="ejercicio1")
     */
    public function ej1Action()
    {
        //Entity manager
        /** @var EntityManager $em */
        $em=$this->getDoctrine()->getManager();
        /*$alumnado= $em->getRepository('AppBundle:Alumno')->findBy([
            'nombre' => 'María',
            'apellidos' => 'Torres Casado'
        ]);*/

        //Con DQL
        //$alumnado = $em->createQuery('SELECT a FROM AppBundle:Alumno a WHERE a.nombre=\'María\'')->getResult();

        //Con DQL y parametros
        /*$alumnado = $em->createQuery('SELECT a FROM AppBundle:Alumno a WHERE a.nombre=:nombre')
            ->setParameter('nombre', 'María')
            ->getResult();*/

        //Query builder con fila completa
        /*$alumnado = $em->createQueryBuilder()
            ->select('a')
            ->from('AppBundle:Alumno', 'a')
            ->where('a.nombre = :nombre')
            ->setParameter('nombre', 'María')
            ->orderBy()
            ->getQuery()
            ->getResult();*/

        //Query builder con propiedades específicas
        $alumnado = $em->createQueryBuilder()
            ->select('a')
            ->from('AppBundle:Alumno', 'a')
            ->where('a.nombre = :nombre')
            ->setParameter('nombre', 'María')
            ->orderBy('a.apellidos')
            ->getQuery()
            ->getResult();

        return $this->render('consultas/alumnado.html.twig', [
            'alumnado' => $alumnado
        ]);
    }
}
