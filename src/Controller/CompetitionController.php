<?php

namespace App\Controller;

use App\Domain\Generator\CompetitionGenerator;
use App\Domain\Generator\GroupGenerator;
use App\Domain\Generator\PlayGenerator;
use App\Domain\Generator\StageGenerator;
use App\Domain\Generator\TeamGenerator;
use App\Domain\Tournaments\CupTournament;
use App\Entity\Group;
use App\Entity\Play;
use App\Entity\Stage;
use App\Entity\Team;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

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
     * @param StageGenerator $stageGenerator
     * @param GroupGenerator $groupGenerator
     * @param PlayGenerator $playGenerator
     * @param TeamGenerator $teamGenerator
     * @return Response
     * @throws \Doctrine\ORM\ORMException
     */
    public function generation(CompetitionGenerator $competitionGenerator,
                               StageGenerator $stageGenerator,
                               GroupGenerator $groupGenerator,
                               PlayGenerator $playGenerator,
                               TeamGenerator $teamGenerator
    )
    {
        $competitionGenerator->setStageGenerator($stageGenerator);
        $competitionGenerator->setGroupGenerator($groupGenerator);
        $competitionGenerator->setPlayGenerator($playGenerator);
        $competitionGenerator->setTeamGenerator($teamGenerator);
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
