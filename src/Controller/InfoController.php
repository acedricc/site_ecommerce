<?php

namespace App\Controller;

use App\Repository\InfoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/info')]
class InfoController extends AbstractController
{
    #[Route('/', name: 'app_info')]
    public function index(InfoRepository $infoRepository): Response
    {
        $infos = $infoRepository->findAll();
        dd($infos);
        return $this->render('info/index.html.twig', [
            'controller_name' => 'InfoController',
        ]);
    }

    #[Route('/new', name: 'app_info_new')]
    public function new(InfoRepository $infoRepository): Response
    {
        $infos = $infoRepository->findAll();
        dd($infos);
        return $this->render('info/new.html.twig', [
            'controller_name' => 'InfoController',
        ]);
    }

    #[Route('/show', name: 'app_info_show')]
    public function show(InfoRepository $infoRepository): Response
    {
        $infos = $infoRepository->findAll();
        dd($infos);
        return $this->render('info/show.html.twig', [
            'controller_name' => 'InfoController',
        ]);
    }

    #[Route('/edit', name: 'app_info_edit')]
    public function edit(InfoRepository $infoRepository): Response
    {
        $infos = $infoRepository->findAll();
        dd($infos);
        return $this->render('info/edit.html.twig', [
            'controller_name' => 'InfoController',
        ]);
    }

    #[Route('/delete', name: 'app_info_delete')]
    public function delete(InfoRepository $infoRepository): Response
    {
        $infos = $infoRepository->findAll();
        dd($infos);
        return $this->render('info/delete.html.twig', [
            'controller_name' => 'InfoController',
        ]);
    }
}
