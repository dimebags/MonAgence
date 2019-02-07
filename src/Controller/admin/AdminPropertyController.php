<?php

namespace App\Controller\Admin;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;


class AdminPropertyController extends AbstractController {

    private $repository;


    public function __construct(PropertyRepository $repository)
    {
            $this->repository = $repository;compac
    }

    public function index() {
        $properties = $this->repository->findAll();
        return $this->render('admin/property/index.html.twig', compacte('properties'));

    }




}