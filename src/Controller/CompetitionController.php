<?php

namespace App\Controller;

use App\Domain\GroupGenerator;
use App\Repository\GroupRepository;
use App\Repository\StageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CompetitionController extends AbstractController
{
    /**
     * @Route("/competition", name="competition")
     * @param StageRepository $repository
     * @return Response
     */
    public function index(StageRepository $repository): Response
    {
        return $this->render('competition/index.html.twig', [
            'controller_name' => 'CompetitionController',
        ]);
    }

    /**
     * @Route("/table", name="table")
     * @param GroupGenerator $generator
     * @param GroupRepository $groupRepository
     * @return Response
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function table(GroupGenerator $generator, GroupRepository $groupRepository): Response
    {
        $generator->generate();
        $groupRepository->setGenerator($generator);
        $groupRepository->addGeneratedRecords();
        return $this->render('competition/index.html.twig', [
            'controller_name' => 'CompetitionController',
        ]);
    }
}
