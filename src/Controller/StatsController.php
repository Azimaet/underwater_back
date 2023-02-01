<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Model\StatsModel;

class StatsController extends AbstractController
{
    private $_statsModel;

    public function __construct(
        StatsModel $statsModel,
    ) {
        $this->_statsModel = $statsModel;
    }

    #[Route('/stats', name: 'app_stats')]
    public function index(): JsonResponse
    {
        $total_dives = $this->_statsModel->getTotalDives();
        $total_users = $this->_statsModel->getTotalUsers();
        $longest_dive = $this->_statsModel->getLongestDive();
        $deepest_dive = $this->_statsModel->getDeepestDive();
        $firstSubscribedUser = $this->_statsModel->getFirstSubscribedUser();
        $lastSubscribedUser = $this->_statsModel->getLastSubscribedUser();
        $mostActiveDiver = $this->_statsModel->getMostActiveDiver();

        return $this->json(
            [
                'totalDives' => $total_dives,
                'longestDive' => $longest_dive,
                'deepestDive' => $deepest_dive,
                'totalUsers' => $total_users,
                'firstUserSubscribed' => $firstSubscribedUser,
                'lastSubscribedUser' => $lastSubscribedUser,
                'mostActiveDiver' => $mostActiveDiver,
            ]
        );
    }
}
