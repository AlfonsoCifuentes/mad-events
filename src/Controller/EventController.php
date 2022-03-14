<?php

namespace App\Controller;

use App\Form\EventoType;
use App\Form\FilterCategoryEventoFormType;
use App\Entity\Evento;
use App\Form\EventoFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\isGranted;
use Symfony\Component\HttpFoundation\Response;



class EventController extends AbstractController{

    #[Route("/", name:"Inicio")]
    public function paginaInicio(){
        return $this->render("inicio.html.twig");
    }


    #[Route("nuevoEvento", name: "nuevoEvento")]
    public function newEvent(Request $request, EntityManagerInterface $em){
        $form=$this->createForm(EventoType::class);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $evento = $form->getData();
            $user = $this->getUser();
            $user->addEvento($evento);
            $em->persist($evento);
            $em->flush();
            return $this->redirectToRoute("myEvents");
        }

        return $this->renderForm("/eventos/createevento.html.twig", ["EventoForm" => $form]);
    }

    #[Route("myEvents", name: "myEvents")]
    public function listEventos(EntityManagerInterface $em){
        $user = $this->getUser();
        $eventos = $user -> getEventos();
        return $this->render("/eventos/myEventos.html.twig", ["eventos" => $eventos, "usuarios" => $user]);
    }

    #[Route("allEvents", name: "allEvents")]
    public function listAllEventos(EntityManagerInterface $em){
        $user = $this->getUser();
        $eventos = $user -> getEventos();
        return $this->render("/eventos/todosLosEventos.html.twig", ["eventos" => $eventos, "usuarios" => $user]);
    }
}