<?php

namespace App\Controller;

use App\Form\EventoType;
use App\Form\FilterCategoryEventoFormType;
use App\Entity\Evento;
use App\Entity\User;
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

        $user = $this->getUser();
        if($user){
            return $this->renderForm("/eventos/createevento.html.twig", ["EventoForm" => $form]);
        }else{
            return $this->render("inicio.html.twig");
        }
        

        
    }

    #[Route("myEvents", name: "myEvents")]
    public function listEventos(EntityManagerInterface $em){
        $user = $this->getUser();
        if($user){
            $eventos = $user -> getEventos();
            return $this->render("/eventos/myEventos.html.twig", ["eventos" => $eventos, "usuarios" => $user]);
        }else{
            return $this->render("inicio.html.twig");
        }

    }

    #[Route("allEvents", name: "allEvents")]
    public function listAllEventos(EntityManagerInterface $em)
    {
       $eventos = $em->getRepository(Evento::class)->findAll();
       return $this->render(
           "/eventos/todosLosEventos.html.twig",
           ["eventos" => $eventos]
        );
    }
}