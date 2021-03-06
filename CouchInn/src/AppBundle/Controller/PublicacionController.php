<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Filter;
use Doctrine\ORM\Mapping as ORM;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Entity\Publicacion;
use AppBundle\Form\PublicacionType;

/**
 * Publicacion controller.
 *
 */
class PublicacionController extends Controller
{
    /**
     * Lists all Publicacion entities.
     * @Route("/home/publicaciones", name="_listaPubli")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $publicaciones = $em->getRepository('AppBundle:Publicacion')
            ->findBy(array(), array('fechaDePublicacion'=>'DESC'));
        return $this->render(':default/publicacion:publicaciones.html.twig', array(
            'publicaciones' => $publicaciones,
            'user' => $this->getUser(),
        ));
    }

    /**
     * Lists all Publicacion entities.
     * @Route("/home/crearFiltro", name="_filtradas")
     */
    public function filtrar(Request $request)
    {
        $filtro = new Filter();
        $form = $this->createForm('AppBundle\Form\FilterType', $filtro);
        $form->handleRequest($request);
        $em = $this->getDoctrine()->getManager();
        $publicaciones = $em->getRepository('AppBundle:Publicacion')->findAll();

        if (!($filtro->getMaxPersonas()==null) or !($filtro->getMonto()==null) or !($filtro->getfechaDisponibleInicio()== null) or !($filtro->getfechaDisponibleFin()== null)
            or !($filtro->getTipo()==null) or !($filtro->getPais()==null)){
            if($filtro->getMaxPersonas()== null){
                $filtro->setMaxPersonas(0);
            }
            if($filtro->getMonto()== null){
                $filtro->setMonto(99999999999);
            }
            if($filtro->getfechaDisponibleInicio()== null){
                $filtro->setfechaDisponibleInicio(new \DateTime('today'));
            }
            if($filtro->getfechaDisponibleFin()== null){
                $filtro->setfechaDisponibleFin(new \DateTime('tomorrow'));
            }
            return $this->render(':default/publicacion:publicacionesFiltradas.html.twig', array('maxPersonas' => $filtro->getMaxPersonas(),
                    'monto'=>$filtro->getMonto(),
                    'fechaInicio'=>$filtro->getfechaDisponibleInicio(),
                    'fechaFin'=>$filtro->getfechaDisponibleFin(),
                    'tipo'=>$filtro->getTipo(),'pais'=>$filtro->getPais(),
                    'publicaciones' => $publicaciones,'user' => $this->getUser())
            );
        }
        return $this->render(':default/publicacion:Filtrar.html.twig', array('form' => $form->createView()));
    }
    
    /**
     * Lists all Publicacion entities.
     * @Route("/home/misPublicaciones", name="_misPublicaciones")
     */
    public function myAction()
    {
        $publicaciones = $this->getUser()->getPublicaciones();
        $preguntas = $this->getDoctrine()
            ->getRepository('AppBundle:Pregunta')
            ->findAll();
        $solicitudes = $this->getDoctrine()
            ->getRepository('AppBundle:Solicitud')
            ->findAll();

        return $this->render(':default/publicacion:misPublicaciones.html.twig', array(
            'publicaciones' => $publicaciones,
            'preguntas' =>$preguntas,
            'solicitudes' =>$solicitudes,
            'user' => $this->getUser(),
        ));
    }

    /**
     * @Route("/home/altaPublicacion", name="_altaPubli")
     */
    public function newAction(Request $request)
    {
        $error = '';
        $publicacion = new Publicacion();
        $publicacion->setUsuario($this->getUser());
        $publicacion->setReservado(false);

        if ($this->getUser()->esPremium()) {
            $form = $this->createForm('AppBundle\Form\PublicacionPremiumType', $publicacion);
        }
        else {
            $form = $this->createForm('AppBundle\Form\PublicacionType', $publicacion);
        }
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $foto = $form['foto']->getData();
            $dir = 'uploads/fotos';

            $extension = $foto->guessExtension();
            if (!$extension) {
                $extension = 'bin';
            }
            $name = md5(uniqid()).'.'.$extension;
            $foto->move($dir, $name);
            $publicacion->setPath($name);
            if ($this->getUser()->esPremium()) {
                $foto2 = $form['foto2']->getData();
                $extension2 = $foto2->guessExtension();
                if (!$extension2) {
                    $extension2 = 'bin';
                }
                $name2 = md5(uniqid()).'.'.$extension2;
                $foto2->move($dir, $name2);
                $publicacion->setPath2($name2);

                $foto3 = $form['foto3']->getData();
                $extension3 = $foto3->guessExtension();
                if (!$extension3) {
                    $extension3 = 'bin';
                }
                $name3 = md5(uniqid()).'.'.$extension3;
                $foto3->move($dir, $name3);
                $publicacion->setPath3($name3);
            }

            $em = $this->getDoctrine()->getManager();
            $em->persist($publicacion);
            $em->flush();
            return $this->redirectToRoute('_listaPubli', array('id' => $publicacion->getId()));
        }

        return $this->render(':default/publicacion:altaPubli.html.twig', array(
            'publicacion' => $publicacion,
            'form' => $form->createView(),
            'error' => $error,
        ));
    }

    /**
     * Finds and displays a Publicacion entity.
     * @Route("/home/publicaciones/{id}", name="_mostrarPublicacion")
     */
    public function showAction($id)
    {
        $publicacion = $this->getDoctrine()
            ->getRepository('AppBundle:Publicacion')
            ->find($id);
        $calificacionesBuenas = $this->getDoctrine()
            ->getRepository('AppBundle:CalificacionPublicacion')
            ->findBy([
                'calificacion'=>1,
                'publicacion'=>$publicacion,
            ]);
        $calificacionesMalas = $this->getDoctrine()
            ->getRepository('AppBundle:CalificacionPublicacion')
            ->findBy([
                'calificacion'=>2,
                'publicacion'=>$publicacion,
            ]);
        $calificacionDelusuarioBuenas = $this->getDoctrine()
            ->getRepository('AppBundle:CalificacionUsuario')
            ->findBy([
                'calificacion'=>1,
                'paraUsuario'=>$publicacion->getUsuario(),
            ]);
        $calificacionesDelUsuarioMalas = $this->getDoctrine()
            ->getRepository('AppBundle:CalificacionUsuario')
            ->findBy([
                'calificacion'=>2,
                'paraUsuario'=>$publicacion->getUsuario(),
            ]);

        $deleteForm = $this->createDeleteForm($publicacion);


        if($publicacion->getUsuario()->esPremium()) {
            return $this->render(':default/publicacion:mostrarPublicacionPremium.html.twig', array(
                'calificacionesBuenas' => count($calificacionesBuenas),
                'calificacionesMalas' => count($calificacionesMalas),
                'calificacionDelUsuarioBuenas' => count($calificacionDelusuarioBuenas),
                'calificacionesDelUsuarioMalas' => count($calificacionesDelUsuarioMalas),
                'publicacion' => $publicacion,
                'comentarios' => $publicacion->getComentarios(),
                'preguntas' => $publicacion->getPregunta(),
                'delete_form' => $deleteForm->createView(),
            ));
        }else {
            return $this->render(':default/publicacion:mostrarPublicacion.html.twig', array(
                'calificacionesBuenas' => count($calificacionesBuenas),
                'calificacionesMalas' => count($calificacionesMalas),
                'calificacionDelUsuarioBuenas' => count($calificacionDelusuarioBuenas),
                'calificacionesDelUsuarioMalas' => count($calificacionesDelUsuarioMalas),
                'publicacion' => $publicacion,
                'comentarios' => $publicacion->getComentarios(),
                'preguntas' => $publicacion->getPregunta(),
                'delete_form' => $deleteForm->createView(),
            ));
        }
    }

    /**
     * Displays a form to edit an existing Publicacion entity.
     * @Route("/home/publicacion/{id}/modificar", name="_modificarPublicacion")
     */
    public function editAction(Request $request, $id)
    {
        $publicacion = $this->getDoctrine()
            ->getRepository('AppBundle:Publicacion')
            ->find($id);
        $deleteForm = $this->createDeleteForm($publicacion);
        $editForm = $this->createForm('AppBundle\Form\PublicacionType', $publicacion);
        $editForm->add('reservado', ChoiceType::class, [
            'choices' => [
                '1' => 'Reservado',
                '0' => 'Sin reservar',
            ]
        ]);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $foto = $editForm['foto']->getData();
            $dir = 'uploads/fotos';

            $extension = $foto->guessExtension();
            if (!$extension) {
                $extension = 'bin';
            }
            $name = md5(uniqid()).'.'.$extension;
            $foto->move($dir, $name);
            $publicacion->setPath($name);
            $publicacion->setFechaDePublicacion(new \DateTime('today'));

            $em = $this->getDoctrine()->getManager();
            $em->persist($publicacion);
            $em->flush();

            return $this->redirectToRoute('_mostrarPublicacion', array('id' => $publicacion->getId()));
        }

        return $this->render(':default/publicacion:modificarPublicacion.html.twig', array(
            'publicacion' => $publicacion,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Publicacion entity.
     * @Route("/home/publicacion/eliminar/{id}", name="_eliminarPublicacion")
     */
    public function deleteAction(Request $request, $id)
    {
        $publicacion = $this->getDoctrine()
            ->getRepository('AppBundle:Publicacion')
            ->find($id);

        $form = $this->createDeleteForm($publicacion);
        $form->handleRequest($request);

        if (!empty($publicacion) and !empty($publicacion->getComentarios())) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($publicacion);
            $em->flush();
        }

        return $this->redirectToRoute('_listaPubli');
    }

    /**
     * Creates a form to delete a Publicacion entity.
     *
     * @param Publicacion $publicacion The Publicacion entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Publicacion $publicacion)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('_eliminarPublicacion', array('id' => $publicacion->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
