<?php

namespace App\Controller;

use App\Domain\Generators\GroupGeneratorInterface;
use App\Domain\Generators\PlayGeneratorInterface;
use App\Domain\Generators\PlayoffGeneratorInterface;
use App\Domain\Generators\PlayOffStageGeneratorInterface;
use App\Domain\Generators\StageGeneratorInterface;
use App\Domain\Generators\TeamGeneratorInterface;
use App\Domain\Generators\TeamPointsGeneratorInterface;
use App\Domain\Strategies\PlainPointStrategy;
use App\Domain\Strategies\PreliminaryRoundPlayoffGridStrategy;
use App\Domain\Tournaments\CupTournament;
use App\Domain\Tournaments\GroupTournament;
use App\Domain\Tournaments\PlayoffTournament;
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

    public function generate(StageRepository $stageRepository){

    }

    /**
     * @Route("/table", name="table")
     * @param GroupGeneratorInterface $generator
     * @param GroupRepository $groupRepository
     * @param TeamGeneratorInterface $teamGenerator
     * @param TeamRepository $teamRepository
     * @param StageGeneratorInterface $stageGenerator
     * @param StageRepository $stageRepository
     * @param PlayGeneratorInterface $playGenerator
     * @param PlayRepository $playRepository
     * @param TeamPointsGeneratorInterface $teamPointsGenerator
     * @param PlainPointStrategy $plainPointStrategy
     * @return Response
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function table(GroupGeneratorInterface $generator, GroupRepository $groupRepository,
                          TeamGeneratorInterface $teamGenerator, TeamRepository $teamRepository,
                          StageGeneratorInterface $stageGenerator, StageRepository $stageRepository,
                          PlayGeneratorInterface $playGenerator, PlayRepository $playRepository,
                          TeamPointsGeneratorInterface $teamPointsGenerator, PlainPointStrategy $plainPointStrategy
    ): Response
    {
        $play = current($groupRepository->findGroups());
//        var_dump($play->getName());
//        die('asd');
        if (!$groupRepository->count([])) {
            $generator->execute();
            $groupRepository->setGenerator($generator);
            $groupRepository->addGeneratedRecords();
            $teamGenerator->execute();
            $teamRepository->setGenerator($teamGenerator);
            $teamRepository->addGeneratedRecords();
            $stageGenerator->execute();
            $stageRepository->setGenerator($stageGenerator);
            $stageRepository->addGeneratedRecords();
            $playGenerator->execute();
            $playRepository->setGenerator($playGenerator);
            $playRepository->addGeneratedRecords();
            $teamPointsGenerator->setPointStrategy($plainPointStrategy);
            $teamPointsGenerator->execute();
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
     * @param CupTournament $cupTournament
     * @return Response
     */
    public function playOffGrid(CupTournament $cupTournament): Response
    {
        $cupTournament->build();
//        $stageRepository->findAll();
//        if (!$stageRepository->count(['isPlayoff' => true])) {
//            $playOffStageGenerator->generate();
//            $stageRepository->setGenerator($playOffStageGenerator);
//            $stageRepository->addGeneratedRecords();
//            $playoffGenerator->setPlayoffGridStrategy($preliminaryRoundPlayoffGridStrategy);
//            $playoffGenerator->generate();
//            $playRepository->setGenerator($playoffGenerator);
//            $playRepository->addGeneratedRecords();
//            $this->getDoctrine()->getManager()->flush();
//        }
        return $this->render('competition/index.html.twig', [
            'controller_name' => '123',
        ]);
    }
}
