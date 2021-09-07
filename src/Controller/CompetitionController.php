<?php

namespace App\Controller;

use App\Domain\Generator\CompetitionGenerator;
use App\Domain\Tournaments\CupTournament;
use App\Repository\StageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CompetitionController extends AbstractController
{
    /**
     * @Route("/competition", name="competition")
     * @param CupTournament $cupTournament
     * @return Response
     */
    public function competition(CupTournament $cupTournament)
    {
        $cupTournament->build();
        return $this->render('grid/competition.html.twig', [
            'cupTournament' => $cupTournament,
        ]);
    }

    /**
     * @Route("/generation", name="generation")
     * @param CompetitionGenerator $competitionGenerator
     * @param StageRepository $stageRepository
     * @return Response
     * @throws \Doctrine\ORM\ORMException
     */
    public function generation(CompetitionGenerator $competitionGenerator)
    {
        $competitionGenerator->execute();
        return $this->redirect('/competition');
    }

    /**
     * @Route("/startPage", name="startPage")
     * @return Response
     */
    public function startPage()
    {
        return $this->render('grid/index.html.twig');
    }
}
