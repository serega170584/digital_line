<?php

namespace App\Controller;

use App\Domain\GroupGenerator;
use App\Domain\PlayGenerator;
use App\Domain\StageGenerator;
use App\Domain\TeamGenerator;
use App\Repository\GroupRepository;
use App\Repository\PlayRepository;
use App\Repository\StageRepository;
use App\Repository\TeamRepository;
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
     * @param TeamGenerator $teamGenerator
     * @param TeamRepository $teamRepository
     * @param StageGenerator $stageGenerator
     * @param StageRepository $stageRepository
     * @param PlayGenerator $playGenerator
     * @param PlayRepository $playRepository
     * @return Response
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function table(GroupGenerator $generator, GroupRepository $groupRepository,
                          TeamGenerator $teamGenerator, TeamRepository $teamRepository,
                          StageGenerator $stageGenerator, StageRepository $stageRepository,
                          PlayGenerator $playGenerator, PlayRepository $playRepository
    ): Response
    {
        $generator->generate();
        $groupRepository->setGenerator($generator);
        $groupRepository->addGeneratedRecords();
        $this->getDoctrine()->getManager()->flush();
        $teamGenerator->generate();
        $teamRepository->setGenerator($teamGenerator);
        $teamRepository->addGeneratedRecords();
        $this->getDoctrine()->getManager()->flush();
        $stageGenerator->generate();
        $stageRepository->setGenerator($stageGenerator);
        $stageRepository->addGeneratedRecords();
        $this->getDoctrine()->getManager()->flush();
        $playGenerator->generate();
        $playRepository->setGenerator($playGenerator);
        $playRepository->addGeneratedRecords();
        $this->getDoctrine()->getManager()->flush();
        return $this->render('competition/index.html.twig', [
            'controller_name' => 'CompetitionController',
        ]);
    }
}
