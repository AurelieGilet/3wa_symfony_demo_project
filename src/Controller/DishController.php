<?php

namespace App\Controller;

use App\Entity\Dish;
use App\Form\DishType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DishController extends AbstractController
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
     * @param Request $request
     * @return Response
     */
    #[Route('/admin/dish/add', name: 'dish_add')]
    public function addDish(Request $request): Response 
    {
        $dish = new Dish();

        $form = $this->createForm(DishType::class, $dish);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->manager->persist($dish);
            $this->manager->flush();
            
            $this->addFlash('success', "Le plat ". $dish->getName() . " a bien été ajouté");

            return $this->redirectToRoute('admin');
        }

        return $this->render('dish/form.html.twig', [
            'controller_name' => 'DishController',
            'form' => $form->createView(),
        ]);
    }

    /**
     * @param Request $request
     * @param Dish $dish
     * @return Response
     */
    #[Route('admin/dish/update/{id}', name:'dish_update')]
    public function updateDish(Request $request, Dish $dish): Response
    {
        $form = $this->createForm(DishType::class, $dish);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $this->manager->persist($dish);
            $this->manager->flush();

            $this->addFlash('success', "Le plat ". $dish->getName() . " a bien été modifié");

            return $this->redirectToRoute('admin');
        }

        return $this->render('dish/form.html.twig', [
            'controller_name' => 'DishController',
            'form' => $form->createView(),
            'dish' => $dish,
        ]);
    }

    /**
     * @param Dish $dish
     * @return Response
     */
    #[Route('/admin/dish/delete/{id}', name:"dish_delete")]
    public function deleteDish(Dish $dish): Response
    {
        $this->manager->remove($dish);
        $this->manager->flush();

        $this->addFlash('success', "Le plat ". $dish->getName() . " a bien été supprimé");

        return $this->redirectToRoute('admin');
    }
}