<?php

namespace App\Controller;

use App\Entity\Ingredient;
use App\Form\IngredientType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class IngredientController extends AbstractController
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
    #[Route('/admin/ingredient/add', name: 'ingredient_add')]
    public function addIngredient(Request $request): Response 
    {
        $ingredient = new Ingredient();

        $form = $this->createForm(IngredientType::class, $ingredient);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->manager->persist($ingredient);
            $this->manager->flush();
            
            $this->addFlash('success', "L'ingrédient ". $ingredient->getName() . " a bien été ajouté");

            return $this->redirectToRoute('admin');
        }

        return $this->render('ingredient/form.html.twig', [
            'controller_name' => 'IngredientController',
            'form' => $form->createView(),
        ]);
    }

    /**
     * @param Request $request
     * @param Ingredient $ingredient
     * @return Response
     */
    #[Route('admin/ingredient/update/{id}', name:'ingredient_update')]
    public function updateIngredient(Request $request, Ingredient $ingredient): Response
    {
        $form = $this->createForm(IngredientType::class, $ingredient);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $this->manager->persist($ingredient);
            $this->manager->flush();

            $this->addFlash('success', "L'ingrédient ". $ingredient->getName() . " a bien été modifié");

            return $this->redirectToRoute('admin');
        }

        return $this->render('ingredient/form.html.twig', [
            'controller_name' => 'IngredientController',
            'form' => $form->createView(),
            'ingredient' => $ingredient,
        ]);
    }

    /**
     * @param Ingredient $ingredient
     * @return Response
     */
    #[Route('/admin/ingredient/delete/{id}', name:"ingredient_delete")]
    public function deleteIngredient(Ingredient $ingredient): Response
    {
        if (count($ingredient->getDishes()) > 0) {
            $this->addFlash('error', "L'ingrédient ". $ingredient->getName() . " ne peut pas être supprimé car il est utilisé dans un plat");

            return $this->redirectToRoute('admin');
        }

        $this->manager->remove($ingredient);
        $this->manager->flush();

        $this->addFlash('success', "L'ingrédient ". $ingredient->getName() . " a bien été supprimé");

        return $this->redirectToRoute('admin');
    }
}
