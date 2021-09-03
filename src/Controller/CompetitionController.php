<?php

namespace App\Controller;

use App\Domain\Generators\GroupGenerator;
use App\Domain\Generators\PlayGenerator;
use App\Domain\Generators\PlayoffGenerator;
use App\Domain\Generators\PlayOffStageGenerator;
use App\Domain\Generators\StageGenerator;
use App\Domain\Generators\TeamGenerator;
use App\Domain\Generators\TeamPointsGenerator;
use App\Domain\Strategies\PlainPointStrategy;
use App\Domain\Strategies\PreliminaryRoundPlayoffGridStrategy;
use App\Domain\Tournaments\GroupTournament;
use App\Domain\Tournaments\PlayoffTournament;
use App\Repository\GroupRepository;
use App\Repository\PlayRepository;
use App\Repository\StageRepository;
use App\Repository\TeamRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

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
        $play = current($groupRepository->findGroups());
        var_dump(current($play->getName()));
        die('asd');
        if ($groupRepository->count([])) {
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
        }
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
        return $this->render('grid/index.html.twig', [
            'groups' => $groupTournament->getUnits(),
        ]);
    }

    /**
     * @Route("/playOffGrid", name="playOffGrid")
     * @param PlayoffGenerator $playoffGenerator
     * @param PlayOffStageGenerator $playOffStageGenerator
     * @param StageRepository $stageRepository
     * @param PlayRepository $playRepository
     * @param PlayoffTournament $playoffTournament
     * @param PreliminaryRoundPlayoffGridStrategy $preliminaryRoundPlayoffGridStrategy
     * @param GroupTournament $groupTournament
     * @return Response
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function playOffGrid(PlayoffGenerator $playoffGenerator, PlayOffStageGenerator $playOffStageGenerator,
                                StageRepository $stageRepository, PlayRepository $playRepository, PlayoffTournament $playoffTournament,
                                PreliminaryRoundPlayoffGridStrategy $preliminaryRoundPlayoffGridStrategy, GroupTournament $groupTournament): Response
    {
        if (!$stageRepository->count(['isPlayoff' => true])) {
            $playOffStageGenerator->generate();
            $stageRepository->setGenerator($playOffStageGenerator);
            $stageRepository->addGeneratedRecords();
            $playoffGenerator->setPlayoffGridStrategy($preliminaryRoundPlayoffGridStrategy);
            $playoffGenerator->generate();
            $playRepository->setGenerator($playoffGenerator);
            $playRepository->addGeneratedRecords();
            $this->getDoctrine()->getManager()->flush();
        }
        return $this->render('grid/playoff.html.twig', [
            'stages' => $playoffTournament->getUnits(),
            'resultTeams' => $stageRepository->getResultTeams(),
            'groups' => $groupTournament->getUnits(),
        ]);
    }
}
