<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Alumno;
use AppBundle\Entity\Grupo;
use AppBundle\Entity\Profesor;
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
     * @Route("/ej7/{parametro}", name="ejercicio7", requirements={"parametro"="\d{4}"})
     */
    public function ej7Action($parametro)
    {
        //$fechaInicio = ($parametro-1)."-12-31";
        //$fechaFin = ($parametro+1)."-01-01";

        //Entity manager
        /** @var EntityManager $em */
        $em=$this->getDoctrine()->getManager();

        $alumnado = $em->createQueryBuilder()
            ->select('a')
            ->from('AppBundle:Alumno', 'a')
            ->where('a.fechaNacimiento > :fechaInicio')
            ->andWhere('a.fechaNacimiento < :fechaFin')
            ->setParameter('fechaInicio', new \DateTime(($parametro - 1) . "-12-31"))
            ->setParameter('fechaFin', new \DateTime(($parametro + 1) . "-01-01"))
            ->orderBy('a.fechaNacimiento', 'DESC')
            ->getQuery()
            ->getResult();

        return $this->render('consultas/alumnado.html.twig', [
            'alumnado' => $alumnado
        ]);
    }
/*
    /**
     * @Route("/ej7/{parametro}", name="errorExpresion")
     */
/*    public function errorExpresionAction($parametro)
    {
        return $this->render('consultas/error_expresion.html.twig', [
            'mensaje' => "El parametro pasado no es un año"
        ]);
    }
*/
    /**
     * @Route("/ej8", name="ejercicio8")
     */
    public function ej8Action()
    {
        //Entity manager
        /** @var EntityManager $em */
        $em=$this->getDoctrine()->getManager();

        $grupos = $em->createQueryBuilder()
            ->select('g')
            ->from('AppBundle:Grupo', 'g')
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

        //Una opcion
        /*$grupos = $em->createQueryBuilder()
            ->select('g')
            ->from('AppBundle:Grupo', 'g')
            ->orderBy('g.descripcion', 'DESC')
            ->groupBy('g.id')
            ->getQuery()
            ->getResult();*/

        //ejecucion sql
        //select g.descripcion, a.grupo_id count(*) form alumno inner join grupo g on g.id=a.grupo_id grupo_id group by a.grupo_id order by g.descripcion desc
        //$grupos = $em->createQuery('SELECT count(a) FROM AppBundle:Grupo a GROUP BY a.descripcion')->getResult();

    /*    //Otra opcion (parecida a sql) Con join
        $grupos = $em->createQueryBuilder()
            ->select('g')
            ->addSelect('COUNT(a)')
            ->from('AppBundle:Alumno', 'a')
            ->innerJoin('AppBundle:Grupo', 'g', 'WITH', 'g.id = a.grupo')
            ->groupBy('g')
            ->orderBy('g.descripcion', 'DESC')
            ->getQuery()
            ->getResult();      */

     /*   //Otra opcion (mejor)
        $grupos = $em->createQueryBuilder()
            ->select('g')
            ->addSelect('COUNT(a)')
            ->from('AppBundle:Grupo', 'g')
            ->join('g.alumnado', 'a')
            ->groupBy('g')
            ->orderBy('g.descripcion', 'DESC')
            ->getQuery()
            ->getResult();          */

        //Otra opcion (óptima)
        $grupos = $em->createQueryBuilder()
            ->select('g')
            ->addSelect('SIZE(g.alumnado)')
            ->addSelect('t')
            ->from('AppBundle:Grupo', 'g')
            ->join('g.tutor', 't')
            ->orderBy('g.descripcion', 'DESC')
            ->getQuery()
            ->getResult();

        dump($grupos);

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
            ->select('g')
            ->from('AppBundle:Grupo', 'g')
            ->orderBy('g.descripcion')
            ->getQuery()
            ->getResult();

        return $this->render('consultas/gruposEnlaces.html.twig', [
            'grupos' => $grupos
        ]);
    }

    /**
     * @Route("/ej11_2/{grupo}", name="ejercicio11_2")
     */
    public function ej11_2Action(Grupo $grupo) //Decimos que $grupo es un objeto de la clase Grupo
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
     * @Route("/ej12", name="ejercicio12")
     */
    public function ej12Action()
    {
        //Entity manager
        /** @var EntityManager $em */
        $em=$this->getDoctrine()->getManager();

        $profesores = $em->createQueryBuilder()
            ->select('p')
            ->from('AppBundle:Profesor', 'p')
            ->getQuery()
            ->getResult();

        return $this->render('consultas/profesoresEnlaces.html.twig', [
            'profesores' => $profesores
        ]);
    }

    /**
     * @Route("/ej12_2/{profesor}", name="ejercicio12_2")
     */
    public function ej12_2Action(Profesor $profesor)
    {
        //Entity manager
        /** @var EntityManager $em */
        $em=$this->getDoctrine()->getManager();

        $partes = $em->createQueryBuilder()
            ->select('p')
            ->addSelect('a')
            ->from('AppBundle:Parte', 'p')
            ->where('p.profesor = :profesor')
            ->setParameter('profesor', $profesor)
            ->orderBy('p.fechaCreacion')
            ->join('p.alumno', 'a')
            ->getQuery()
            ->getResult();

        return $this->render('consultas/partes.html.twig', [
            'partes' => $partes,
            'profesor' => $profesor
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

    /*    //Solución cutre sin ordenar
        $alumnado = $em->createQueryBuilder()
            ->select('a')
            ->addSelect('COUNT(p)')
            ->from('AppBundle:Alumno', 'a')
            ->join('AppBundle:Parte', 'p', 'WITH', 'a.id = p.alumno')
            ->groupBy('a')
            ->getQuery()
            ->getResult();              */

        $alumnado = $em->createQueryBuilder()
            ->select('a')
            ->addSelect('SIZE(a.partes)')
            ->from('AppBundle:Alumno', 'a')
            ->orderBy('SIZE(a.partes)')
            ->getQuery()
            ->getResult();

        return $this->render('consultas/alumnadoPartes.html.twig', [
            'alumnado' => $alumnado
        ]);
    }

    /**
     * @Route("/ej14/{texto}", name="ejercicio14")
     */
    public function ej14Action($texto)
    {
        //Entity manager
        /** @var EntityManager $em */
        $em=$this->getDoctrine()->getManager();

        $partes = $em->createQueryBuilder()
            ->select('p')
            ->from('AppBundle:Parte', 'p')
            ->where('p.observaciones LIKE :texto')
            ->setParameter('texto',  '%'. $texto .'%') //->setParameter('texto',  "% $texto %")
            ->getQuery()
            ->getResult();

        return $this->render('consultas/partesObservaciones.html.twig', [
            'partes' => $partes,
            'texto' => $texto
        ]);
    }

    /**
     * @Route("/ej15", name="ejercicio15")
     */
    public function ej15Action()
    {
        //Entity manager
        /** @var EntityManager $em */
        $em=$this->getDoctrine()->getManager();

        $partes = $em->createQueryBuilder()
            ->select('p')
            ->from('AppBundle:Parte', 'p')
            ->where('p.alumno IS NULL')
            ->getQuery()
            ->getResult();

        return $this->render('consultas/partes.html.twig', [
            'partes' => $partes     //Hay que borrar el h1 de la plantilla
        ]);
    }

    /**
     * @Route("/ej16", name="ejercicio16")
     */
    public function ej16Action()
    {
        //Entity manager
        /** @var EntityManager $em */
        $em=$this->getDoctrine()->getManager();

        $profesores = $em->createQueryBuilder()
            ->select('p')
            ->from('AppBundle:Profesor', 'p')
            ->where('SIZE(p.partes) = 0')
            ->getQuery()
            ->getResult();

        return $this->render('consultas/profesorado.html.twig', [
            'profesores' => $profesores
        ]);
    }

    /**
     * @Route("/ej17", name="ejercicio17")
     */
    public function ej17Action()
    {
        //Entity manager
        /** @var EntityManager $em */
        $em=$this->getDoctrine()->getManager();

        $alumnos = $em->createQueryBuilder()
            ->select('a')
            ->addSelect('g')
            ->from('AppBundle:Alumno', 'a')
            ->where('SIZE(a.partes) = 0')
            ->join('a.grupo', 'g')
            ->getQuery()
            ->getResult();

        return $this->render('consultas/alumnado.html.twig', [
            'alumnado' => $alumnos
        ]);
    }

}
