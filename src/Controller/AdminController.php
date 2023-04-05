<?php

namespace App\Controller;

use App\Repository\DishRepository;
use App\Repository\MenuRepository;
use App\Repository\IngredientRepository;
use App\Repository\RestaurantRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminController extends AbstractController
{
    /**
     * @param RestaurantRepository $restaurantRepository
     * @param IngredientRepository $ingredientRepository
     * @param DishRepository $dishRepository
     * @param MenuRepository $menuRepository
     * 
     * @return Response
     */
    #[Route('/admin', name: 'admin')]
    public function index(
        RestaurantRepository $restaurantRepository,
        IngredientRepository $ingredientRepository,
        DishRepository $dishRepository,
        MenuRepository $menuRepository,
    ): Response
    {
        $restaurants = $restaurantRepository->findAll();
        $ingredients = $ingredientRepository->findAll();
        $dishes = $dishRepository->findAll();
        $menus = $menuRepository->findAll();

        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
            'restaurants' => $restaurants,
            'ingredients' => $ingredients,
            'dishes' => $dishes,
            'menus' => $menus
        ]);
    }
}
