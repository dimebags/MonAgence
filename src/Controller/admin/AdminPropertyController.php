<?php

namespace App\Controller\admin;


use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Repository\PropertyRepository;
use App\Entity\Property;
use App\Form\PropertyType;
use Symfony\Component\HttpFoundation\Tests\RequestContentProxy;

class AdminPropertyController extends AbstractController {

    private $repository;


    public function __construct(PropertyRepository $repository, ObjectManager $em)
    {
            $this->repository = $repository;
            $this->em = $em;
    }

    public function index() {
        $properties = $this->repository->findAll();
        return $this->render('admin/property/index.html.twig', compact('properties'));

    }

    public function new(Request $request) {
        $property = new Property();
        $form = $this->createForm(PropertyType::class, $property);
        $form->handleRequest($request);
        dump("test");
        if($form->isSubmitted() && $form->isValid()) {
            $this->em->persist();
            $this->em->flush();
            return $this->redirectToRoute("admin.property.index");
        }
        return $this->render('admin/property/new.html.twig', ["property" => $property, "form"=>$form->createView()]);

    }

    public function edit(Property $property, Request $request) {

       $form = $this->createForm(PropertyType::class, $property); // creation du formulaire
        //Traitement du post formulaire
        $form->handleRequest($request);//test s'il y a du changement au niveau des données

        if($form->isSubmitted() && $form->isValid()) {
            $this->em->flush();// no persist because update
            return $this->redirectToRoute("admin.property.index");
        }
       return $this->render('admin/property/edit.html.twig', ["property" => $property, "form"=>$form->createView()]);


    }






}