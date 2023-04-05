<?php

namespace App\Controller;

use App\Entity\Restaurant;
use App\Form\RestaurantType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class RestaurantController extends AbstractController
{
    private EntityManagerInterface $manager;

    /**
     * @param EntityManagerInterface $manager
     */
    public function __construct(EntityManagerInterface $manager)
    {
        $this->manager = $manager;
    }


    /**
     * @param Restaurant $restaurant
     * @return Response
     */
    #[Route('/restaurant/{id}', name: 'restaurant_details')]
    public function index(Restaurant $restaurant): Response
    {
        return $this->render('restaurant/index.html.twig', [
            'controller_name' => 'RestaurantController',
            'restaurant' => $restaurant
        ]);
    }

    /**
     * @param Request $request
     * @return Response
     */
    #[Route('/admin/restaurant/add', name: 'restaurant_add')]
    public function addRestaurant(Request $request): Response 
    {
        $restaurant = new Restaurant();

        $form = $this->createForm(RestaurantType::class, $restaurant);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->manager->persist($restaurant);
            $this->manager->flush();
            
            $this->addFlash('success', "Le restaurant ". $restaurant->getName() . " a bien été ajouté");

            return $this->redirectToRoute('admin');
        }

        return $this->render('restaurant/form.html.twig', [
            'controller_name' => 'RestaurantController',
            'form' => $form->createView(),
        ]);
    }

    /**
     * @param Request $request
     * @param Restaurant $restaurant
     * @return Response
     */
    #[Route('admin/restaurant/update/{id}', name:'restaurant_update')]
    public function updateRestaurant(Request $request, Restaurant $restaurant): Response
    {
        $form = $this->createForm(RestaurantType::class, $restaurant);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $this->manager->persist($restaurant);
            $this->manager->flush();

            $this->addFlash('success', "Le restaurant ". $restaurant->getName() . " a bien été modifié");

            return $this->redirectToRoute('admin');
        }

        return $this->render('restaurant/form.html.twig', [
            'controller_name' => 'RestaurantController',
            'form' => $form->createView(),
            'restaurant' => $restaurant,
        ]);
    }

    /**
     * @param Restaurant $restaurant
     * @return Response
     */
    #[Route('/admin/restaurant/delete/{id}', name:"restaurant_delete")]
    public function deleteRestaurant(Restaurant $restaurant): Response
    {
        $this->manager->remove($restaurant);
        $this->manager->flush();

        $this->addFlash('success', "Le restaurant ". $restaurant->getName() . " a bien été supprimé");

        return $this->redirectToRoute('admin');
    }
}
