<?php

namespace App\Controller;

use App\Entity\Player;
use Doctrine\ORM\EntityManagerInterface;
use GuzzleHttp\Client;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

class DefaultController extends AbstractController {

    public function updatePlayer(EntityManagerInterface $entityManager)
    {
        $Players = $entityManager->getRepository(Player::class)->findAll();

        $steam_api_key = $this->getParameter('steam_api_key');

        $client = new Client();
        /** @var Player $player */
        foreach ($Players as $player) {

            $last_match = true;
            while ($last_match) {
                    $url = 'https://api.steampowered.com/ICSGOPlayers_730/GetNextMatchSharingCode/v1?key=' . $steam_api_key . '&steamid=' . $player->getSteamId() . '&steamidkey=' . $player->getAuthToken() . '&knowncode=' . $player->getLastCsgoMatchCode();
                    $res = $client->request('GET', $url);
                    if ($res->getStatusCode() === 200) {
                        $json = json_decode($res->getBody(), false);
                        $nextcode = $json->result->nextcode;
                        $sharecode = 'steam://rungame/730/76561202255233023/+csgo_download_match%20' . $nextcode;

                        $postAjax = $client->request('POST', 'https://csgostats.gg/match/upload/ajax', [
                            'json' => [
                                'sharecode' => $sharecode,
                                'index' => 1,
                            ],
                        ]);

                        $jsonpost = json_decode($postAjax->getBody(), false);
                        $status = $jsonpost->status;
                        if ($status === 'complete' || $status === 'queued') {
                            $player->setLastCsgoMatchCode($nextcode);
                        }
                    } else {
                        $last_match = false;
                    }
                    $entityManager->persist($player);
            }
        }
        $entityManager->flush();

        return new JsonResponse('Done.');
    }
}
