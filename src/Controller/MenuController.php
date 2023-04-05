<?php

namespace App\Controller;

use App\Entity\Menu;
use App\Form\MenuType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MenuController extends AbstractController
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
    #[Route('/admin/menu/add', name: 'menu_add')]
    public function addMenu(Request $request): Response 
    {
        $menu = new Menu();

        $form = $this->createForm(MenuType::class, $menu);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->manager->persist($menu);
            $this->manager->flush();
            
            $this->addFlash('success', "Le menu ". $menu->getName() . " a bien été ajouté");

            return $this->redirectToRoute('admin');
        }

        return $this->render('menu/form.html.twig', [
            'controller_name' => 'MenuController',
            'form' => $form->createView(),
        ]);
    }

    /**
     * @param Request $request
     * @param Menu $menu
     * @return Response
     */
    #[Route('admin/menu/update/{id}', name:'menu_update')]
    public function updateMenu(Request $request, Menu $menu): Response
    {
        $form = $this->createForm(MenuType::class, $menu);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $this->manager->persist($menu);
            $this->manager->flush();

            $this->addFlash('success', "Le menu ". $menu->getName() . " a bien été modifié");

            return $this->redirectToRoute('admin');
        }

        return $this->render('menu/form.html.twig', [
            'controller_name' => 'MenuController',
            'form' => $form->createView(),
            'menu' => $menu,
        ]);
    }

    /**
     * @param Menu $menu
     * @return Response
     */
    #[Route('/admin/menu/delete/{id}', name:"menu_delete")]
    public function deleteMenu(Menu $menu): Response
    {
        $this->manager->remove($menu);
        $this->manager->flush();

        $this->addFlash('success', "Le menu ". $menu->getName() . " a bien été supprimé");

        return $this->redirectToRoute('admin');
    }
}
