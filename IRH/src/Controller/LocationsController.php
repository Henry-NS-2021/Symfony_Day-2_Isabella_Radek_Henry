<?php

namespace App\Controller;

use App\Entity\Locations;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LocationsController extends AbstractController
{
    #[Route("/locations", name:"indexAction")]

    public function indexAction()

    {

        $locations = $this->getDoctrine()
            
            ->getRepository(Locations::class)

            ->findAll();// this variable $locations will store the result of running a query to find all the locations

        return $this->render('locations/index.html.twig',array( "locations"=>$locations));

// i send the variable that have all the locations as an array of objects to the index.html.twig page

    }



    #[Route("/create", name:"createAction")]

    public function createAction()

    {  

       

        // you can fetch the EntityManager via $this->getDoctrine()

        // or you can add an argument to your action: createAction(EntityManagerInterface $em)

        $em = $this->getDoctrine()->getManager();

        $location = new Locations(); // here we will create an object from our class location.

        $location->setName('Wladiwostok'); // in our location class we have a set function for each column in our db
        $location->setImage(''); // in our location class we have a set function for each column in our db
        $location->setPrice(99.80);
        $location->setDescription('Lorem ipsum 4th'); 

        // tells Doctrine you want to (eventually) save the location (no queries yet)

        $em->persist($location);

        // actually executes the queries (i.e. the INSERT query)

        $em->flush();

        return new Response('Saved new location with id ' .$location->getId());

    }
    #[Route("/details/{locationId}", name:"detailsAction")]

    public function showdetailsAction($locationId)

    {

        $location = $this->getDoctrine()

            ->getRepository(Locations::class)

            ->find($locationId);

        if (!$location) {

            throw $this->createNotFoundException(

                'No location found for id '.$locationId

            );

        }else {

            return new Response('Details from the location with id ' .$locationId.", location name is ".$location->getName()." and it cost ".$location->getPrice(). " €. <br> Description:" . $location->getDescription(). "<br>" . $location->getImage());

        }

       

    }


}
