<?php

namespace App\Controller;

use App\Domain\Generator\CompetitionGenerator;
use App\Domain\Generator\TeamPointsGeneratorInterface;
use App\Domain\Tournaments\CupTournament;
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
     * @param CompetitionGenerator $competitionGenerator
     * @param CupTournament $cupTournament
     * @return Response
     * @throws \Doctrine\ORM\ORMException
     */
    public function index(CompetitionGenerator $competitionGenerator,
                             CupTournament $cupTournament)
    {
        $competitionGenerator->execute();
        $cupTournament->build();
        return $this->render('grid/index.html.twig', [
            'cupTournament' => $cupTournament,
        ]);
    }

}
