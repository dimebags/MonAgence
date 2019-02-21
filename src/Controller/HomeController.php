<?php


namespace App\Controller;
use App\Repository\PropertyRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;

class HomeController extends AbstractController
{


    public function index(PropertyRepository $repository): Response
    {
        $allProperties = $repository->findAllVisible();
        return $this->render("pages/home.html.twig", ["properties"=>$allProperties]);
    }


}