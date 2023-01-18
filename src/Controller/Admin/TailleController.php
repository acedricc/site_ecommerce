<?php

namespace App\Controller\Admin;

use App\Entity\Taille;
use App\Form\TailleType;
use App\Repository\TailleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('admin/taille')]
class TailleController extends AbstractController
{
    #[Route('/', name: 'app_admin_taille_index', methods: ['GET'])]
    public function index(TailleRepository $tailleRepository): Response
    {
        return $this->render('admin/taille/index.html.twig', [
            'tailles' => $tailleRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_admin_taille_new', methods: ['GET', 'POST'])]
    public function new(Request $request, TailleRepository $tailleRepository): Response
    {
        $taille = new Taille();
        $form = $this->createForm(TailleType::class, $taille);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $tailleRepository->save($taille, true);

            return $this->redirectToRoute('app_admin_taille_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/taille/new.html.twig', [
            'taille' => $taille,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_taille_show', methods: ['GET'])]
    public function show(Taille $taille): Response
    {
        return $this->render('admin/taille/show.html.twig', [
            'taille' => $taille,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admin_taille_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Taille $taille, TailleRepository $tailleRepository): Response
    {
        $form = $this->createForm(TailleType::class, $taille);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $tailleRepository->save($taille, true);

            return $this->redirectToRoute('app_admin_taille_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/taille/edit.html.twig', [
            'taille' => $taille,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_taille_delete', methods: ['POST'])]
    public function delete(Request $request, Taille $taille, TailleRepository $tailleRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$taille->getId(), $request->request->get('_token'))) {
            $tailleRepository->remove($taille, true);
        }

        return $this->redirectToRoute('app_taille_index', [], Response::HTTP_SEE_OTHER);
    }
}
