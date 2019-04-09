<?php


namespace App\Controller;
use App\Entity\PropertySearch;
use App\Form\PropertySearchType;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use App\Repository\PropertyRepository;
use Symfony\Component\HttpFoundation\Tests\RequestContentProxy;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;
use App\Entity\Property;
use Symfony\Component\HttpFoundation\Request;
use Knp\Component\Pager\PaginatorInterface;

class PropertyController extends AbstractController
{
    private $repository;

    public function __construct(PropertyRepository $repository, ObjectManager $em)
    {
        $this->repository = $repository;
        $this->em = $em;

    }

    public function index(PaginatorInterface $paginator ,Request $request): Response
    {

        $search = new PropertySearch();
        $form = $this->createForm(PropertySearchType::class, $search);
        $form->handleRequest($request);

        /*dump($all);
        $property = new Property();
        $property->setTitle('Mon premier bien')
                    ->setRooms(4)
                    ->setBedrooms(3)
                    ->setDescription('une petite description')
                    ->setSurface(60)
                    ->setFloor(4)
                    ->setHeat(1)
            ->setPrice(200000)
                    ->setCity('Paris')
                    ->setAddress('15 Boulevard de la république')
                    ->setPostalCode("75005")

                    ;
        $em = $this->getDoctrine()->getManager();
        $em->persist($property);
        $em->flush();*/

        $allProperties = $paginator->paginate(
            $this->repository->findAllVisibleQuery($search),
            $request->query->getInt('page', 1),
            12
        );

        return $this->render("pages/property.html.twig",["current_menu"=>'properties',
            "properties"=>$allProperties,"form"=>$form->createView()]
            );
    }



    public function show($slug,$id): Response
    {
        $property = $this->repository->find($id);
        return $this->render("pages/show.html.twig",["current_menu"=>'properties',
            "property"=>$property] );
    }


}