<?php

namespace App\Controller;

use App\Domain\Generators\GroupGenerator;
use App\Domain\Generators\PlayGenerator;
use App\Domain\Generators\StageGenerator;
use App\Domain\Generators\TeamGenerator;
use App\Domain\Generators\TeamPointsGenerator;
use App\Domain\Strategies\PlainPointStrategy;
use App\Domain\Tournaments\GroupTournament;
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
     * @param TeamPointsGenerator $teamPointsGenerator
     * @param PlainPointStrategy $plainPointStrategy
     * @return Response
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function table(GroupGenerator $generator, GroupRepository $groupRepository,
                          TeamGenerator $teamGenerator, TeamRepository $teamRepository,
                          StageGenerator $stageGenerator, StageRepository $stageRepository,
                          PlayGenerator $playGenerator, PlayRepository $playRepository,
                          TeamPointsGenerator $teamPointsGenerator, PlainPointStrategy $plainPointStrategy
    ): Response
    {
        $generator->generate();
        $groupRepository->setGenerator($generator);
        $groupRepository->addGeneratedRecords();
        $teamGenerator->generate();
        $teamRepository->setGenerator($teamGenerator);
        $teamRepository->addGeneratedRecords();
        $stageGenerator->generate();
        $stageRepository->setGenerator($stageGenerator);
        $stageRepository->addGeneratedRecords();
        $playGenerator->generate();
        $playRepository->setGenerator($playGenerator);
        $playRepository->addGeneratedRecords();
        $teamPointsGenerator->setPointStrategy($plainPointStrategy);
        $teamPointsGenerator->generate();
        $this->getDoctrine()->getManager()->flush();
        return $this->render('competition/index.html.twig', [
            'controller_name' => 'CompetitionController',
        ]);
    }

    /**
     * @Route("/grid", name="grid")
     * @param GroupTournament $groupTournament
     * @return Response
     */
    public function grid(GroupTournament $groupTournament): Response
    {
        var_dump($groupTournament->getUnits());
        die('asd');
        return $this->render('grid/index.html.twig', [
            'groups' => $groupTournament->getUnits(),
        ]);
    }
}
