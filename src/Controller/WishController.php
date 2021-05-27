<?php

namespace App\Controller;

use App\Entity\Wish;
use App\Form\WishType;
use App\Repository\WishRepository;
use Doctrine\ORM\EntityManagerInterface;
use phpDocumentor\Reflection\DocBlock\Tags\Author;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class WishController extends AbstractController
{
    /**
     * @Route("/wish", name="wish_list")
     */
    public function list( WishRepository $wishRepository, EntityManagerInterface $entityManager): Response
    {

        $title = "List of wishes";

        //Recuperer le repository de wish
        $wishes = $wishRepository->findBy([], ["dateCreated" => "DESC"], 50, 0);


        return $this->render('wish/list.html.twig', [
            "wishes" => $wishes,
            "title" => $title
        ]);
    }

    /**
     * @Route("/wish/detail/{id}", name="wish_detail")
     */
    public function detail($id, WishRepository $wishRepository): Response
    {

        $wishes = $wishRepository->find($id);

        if(!$wishes){
            return $this->redirectToRoute('main_home');
        }

        return $this->render('wish/detail.html.twig', [
            "wishes" => $wishes

        ]);
    }

    /**
     * @Route("/wish/bestof", name="wish_listBestWish")
     */
    public function bestOf(WishRepository $wishRepository): Response
    {

        $title = "Best of wishes";

        $wishes = $wishRepository->findBestWishes();

        if(!$wishes){
            return $this->redirectToRoute('main_home');
        }

        return $this->render('wish/list.html.twig', [
            "wishes" => $wishes,
            "title" => $title

        ]);
    }

    /**
     * @Route("/wish/create/", name="wish_create")
     */
    public function create(Request $request, EntityManagerInterface $entityManager): Response
    {

        $wish = new Wish();
        $wish->setAuthor($this->getUser()->getUsername());

        $wishForm = $this->createForm(WishType::class, $wish);
        $wish->setDateCreated(new \DateTime());
        $wish->setIsPublished(true);
        $wishForm->handleRequest($request);

        if($wishForm->isSubmitted() && $wishForm->isValid()){

            $entityManager->persist($wish);
            $entityManager->flush();

            $this->addFlash('success', 'Idea successfully added !');
            return $this->redirectToRoute('wish_detail', ['id' => $wish->getId()]);
        }


        return $this->render('wish/create.html.twig', [
            'wishForm' => $wishForm->createView()
        ]);
    }
}
