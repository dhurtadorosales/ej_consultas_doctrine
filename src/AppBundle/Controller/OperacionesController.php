<?php

namespace AppBundle\Controller;

use AppBundle\AppBundle;
use AppBundle\Entity\Alumno;
use AppBundle\Entity\Grupo;
use AppBundle\Entity\Profesor;
use Doctrine\ORM\EntityManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;

class OperacionesController extends Controller
{
    /**
     * @Route("/crear_grupo/{nombre}/{aula}/{planta}/{tutor_id}", name="crear_grupo")
     */
    public function crearGrupoAction($nombre, $aula, $planta, $tutor_id)
    {
        //Entity manager
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        //Le asignamos el profesor con id 42
        $tutor= $em->getRepository('AppBundle:Profesor')->find($tutor_id);

        //Insercion
        $grupo1 = new Grupo();
        $em->persist($grupo1);
        $grupo1
            ->setDescripcion($nombre)
            ->setAula($aula)
            ->setPlanta($planta)
            ->setTutor($tutor);

        //Finalizar transacción
        $em->flush();

        return $this->render('operaciones/crear_grupo.html.twig');
    }

    /**
     * @Route("/borrar_grupo/{nombre}", name="borrar_grupo")
     */
    public function borrarGrupoAction($nombre)
    {
        //Entity manager
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        $grupo= $em->getRepository('AppBundle:Grupo')->findOneBy(['descripcion' => $nombre]);

        //Borramos si existe
        if ($grupo) {
            $em->remove($grupo);
            //Finalizar transacción
            $em->flush();
            $mensaje= 'Grupo borrado con éxito';
        } else {
            $mensaje= 'Grupo no encontrado';
        }

        return $this->render('operaciones/crear_grupo.html.twig', [  //Usamos misma plantilla
            'mensaje' => $mensaje
        ]);
    }


    //Para el update usamos el set y le asignamos un flush
    //$grupo->setDescription('hola');

    /**
     * @Route("/grupo/{descripcion}", name="form_grupo")
     */
    public function formularioGrupoAction(Request $request, Grupo $grupo)
    {
        //Entity manager
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        $form= $this->createFormBuilder($grupo)
            ->add('descripcion', null, [
                'label' => 'Nombre completo',
                'disabled' => true
            ])
            ->add('aula')
            ->add('planta')
            ->add('tutor', null, [
                'expanded' => false
            ])
            ->add('guardar', SubmitType::class)
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $em->flush();
        }

        return $this->render('operaciones/modificar_grupo.html.twig', [
            'grupo' => $grupo,
            'form' => $form->createView()
        ]);
    }

}

