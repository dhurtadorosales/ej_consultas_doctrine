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

    /**
     * @Route("/ej2", name="ejercicio2")
     */
    public function ej2Action()
    {
        //Entity manager
        /** @var EntityManager $em */
        $em=$this->getDoctrine()->getManager();

        $alumnado = $em->createQueryBuilder()
            ->select('a')
            ->from('AppBundle:Alumno', 'a')
            ->where('a.nombre != :nombre')
            ->setParameter('nombre', 'María')
            ->orderBy('a.apellidos')
            ->getQuery()
            ->getResult();

        return $this->render('consultas/alumnado.html.twig', [
            'alumnado' => $alumnado
        ]);
    }

    /**
     * @Route("/ej3/{parametro}", name="ejercicio3")
     */
    public function ej3Action($parametro)
    {
        //Entity manager
        /** @var EntityManager $em */
        $em=$this->getDoctrine()->getManager();

        $alumnado = $em->createQueryBuilder()
            ->select('a')
            ->from('AppBundle:Alumno', 'a')
            ->where('a.nombre = :nombre')
            ->setParameter('nombre', $parametro)
            ->orderBy('a.apellidos')
            ->getQuery()
            ->getResult();

        return $this->render('consultas/alumnado.html.twig', [
            'alumnado' => $alumnado
        ]);
    }

    /**
     * @Route("/ej4", name="ejercicio4")
     */
    public function ej4Action()
    {
        //Entity manager
        /** @var EntityManager $em */
        $em=$this->getDoctrine()->getManager();

        $alumnado = $em->createQueryBuilder()
            ->select('a')
            ->from('AppBundle:Alumno', 'a')
            ->where('a.apellidos LIKE :apellidoPrimero')
            ->setParameter('apellidoPrimero', 'Ojeda %')
            ->orderBy('a.nombre')
            ->getQuery()
            ->getResult();

        return $this->render('consultas/alumnado.html.twig', [
            'alumnado' => $alumnado
        ]);
    }

    /**
     * @Route("/ej5", name="ejercicio5")
     */
    public function ej5Action()
    {
        //Entity manager
        /** @var EntityManager $em */
        $em=$this->getDoctrine()->getManager();

        $alumnado = $em->createQueryBuilder()
            ->select('a')
            ->from('AppBundle:Alumno', 'a')
            ->where('a.fechaNacimiento > :fechaInicio')
            ->andWhere('a.fechaNacimiento < :fechaFin')
            ->setParameter('fechaInicio', new \DateTime('1996-12-31'))
            ->setParameter('fechaFin', new \DateTime('1998-01-01'))
            ->orderBy('a.nombre')
            ->getQuery()
            ->getResult();

        return $this->render('consultas/alumnado.html.twig', [
            'alumnado' => $alumnado
        ]);
    }

    /**
     * @Route("/ej6", name="ejercicio6")
     */
    public function ej6Action()
    {
        //Entity manager
        /** @var EntityManager $em */
        $em=$this->getDoctrine()->getManager();

        $resultado = $em->createQueryBuilder()
            ->select('COUNT(a)')
            ->from('AppBundle:Alumno', 'a')
            ->where('a.fechaNacimiento > :fechaInicio')
            ->andWhere('a.fechaNacimiento < :fechaFin')
            ->setParameter('fechaInicio', new \DateTime('1996-12-31'))
            ->setParameter('fechaFin', new \DateTime('1998-01-01'))
            ->getQuery()
            ->getSingleScalarResult();

        return $this->render('consultas/cantidades.html.twig', [
            'numero' => $resultado
        ]);
    }

    /**
     * @Route("/ej7/{anio}", name="ejercicio7")
     */
    public function ej7Action($anio)
    {
        $fechaInicio= ($anio-1)."-12-31";
        $fechaFin= ($anio+1)."-01-01";

        //Entity manager
        /** @var EntityManager $em */
        $em=$this->getDoctrine()->getManager();

        $alumnado = $em->createQueryBuilder()
            ->select('a')
            ->from('AppBundle:Alumno', 'a')
            ->where('a.fechaNacimiento > :fechaInicio')
            ->andWhere('a.fechaNacimiento < :fechaFin')
            ->setParameter('fechaInicio', new \DateTime($fechaInicio))
            ->setParameter('fechaFin', new \DateTime($fechaFin))
            ->orderBy('a.fechaNacimiento', 'DESC')
            ->getQuery()
            ->getResult();

        return $this->render('consultas/alumnado.html.twig', [
            'alumnado' => $alumnado
        ]);
    }

    /**
     * @Route("/ej8", name="ejercicio8")
     */
    public function ej8Action()
    {
        //Entity manager
        /** @var EntityManager $em */
        $em=$this->getDoctrine()->getManager();

        $grupos = $em->createQueryBuilder()
            ->select('a')
            ->from('AppBundle:Grupo', 'a')
            ->orderBy('a.descripcion')
            ->getQuery()
            ->getResult();

        return $this->render('consultas/grupos.html.twig', [
            'grupos' => $grupos
        ]);
    }


    /**
     * @Route("/ej10", name="ejercicio10")
     */
    public function ej10Action()
    {
        //Entity manager
        /** @var EntityManager $em */
        $em=$this->getDoctrine()->getManager();

        /*$grupos = $em->createQueryBuilder()
            ->select('a', 'count(a)')
            ->from('AppBundle:Grupo', 'a')
            ->groupBy('a.id')
            ->getQuery()
            ->getResult();*/

        $grupos = $em->createQuery('SELECT count(a) FROM AppBundle:Grupo a GROUP BY a.descripcion')->getResult();

        return $this->render('consultas/consulta10.html.twig', [
            'grupos' => $grupos
        ]);
    }

    /**
     * @Route("/ej11", name="ejercicio11")
     */
    public function ej11Action()
    {
        //Entity manager
        /** @var EntityManager $em */
        $em=$this->getDoctrine()->getManager();

        $grupos = $em->createQueryBuilder()
            ->select('a')
            ->from('AppBundle:Grupo', 'a')
            ->orderBy('a.descripcion')
            ->getQuery()
            ->getResult();

        return $this->render('consultas/gruposEnlaces.html.twig', [
            'grupos' => $grupos
        ]);
    }

    /**
     * @Route("/ej11_2/{grupo}", name="ejercicio11_2")
     */
    public function ej11_2Action($grupo)
    {
        //Entity manager
        /** @var EntityManager $em */
        $em=$this->getDoctrine()->getManager();

        $alumnado = $em->createQueryBuilder()
            ->select('a')
            ->from('AppBundle:Alumno', 'a')
            ->where('a.grupo = :grupo')
            ->setParameter('grupo', $grupo)
            ->orderBy('a.apellidos')
            ->addOrderBy('a.nombre')
            ->getQuery()
            ->getResult();

        return $this->render('consultas/alumnado.html.twig', [
            'alumnado' => $alumnado
        ]);
    }

    /**
     * @Route("/ej13", name="ejercicio13")
     */
    public function ej13Action()
    {
        //Entity manager
        /** @var EntityManager $em */
        $em=$this->getDoctrine()->getManager();

        $alumnado = $em->createQueryBuilder()
            ->select('a')
            ->from('AppBundle:Alumno', 'a')
            ->getQuery()
            ->getResult();

        return $this->render('consultas/alumnadoPartes.html.twig', [
            'alumnado' => $alumnado
        ]);
    }
}
