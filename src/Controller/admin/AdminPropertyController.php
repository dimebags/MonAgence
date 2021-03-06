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
        if($form->isSubmitted() && $form->isValid()) {

            $this->em->persist($property);
            $this->em->flush();
            $this->addFlash('success', 'Bien edité avec succès');

            return $this->redirectToRoute("admin.property.index");
        }
        return $this->render('admin/property/new.html.twig', ["property" => $property, "form"=>$form->createView()]);

    }

    public function delete(Property $property, Request $request) {

            $this->em->remove($property);
            $this->em->flush();
            $this->addFlash('success', 'Bien supprimé avec succès');
            return $this->redirectToRoute("admin.property.index");

    }


    public function edit(Property $property, Request $request) {

       $form = $this->createForm(PropertyType::class, $property); // creation du formulaire
        //Traitement du post formulaire
        $form->handleRequest($request);//test s'il y a du changement au niveau des données

        if($form->isSubmitted() && $form->isValid()) {
            $this->em->flush();// no persist because update
            $this->addFlash('success', 'Bien modifié avec succès');
            return $this->redirectToRoute("admin.property.index");
        }
       return $this->render('admin/property/edit.html.twig', ["property" => $property, "form"=>$form->createView()]);


    }






}