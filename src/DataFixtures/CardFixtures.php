<?php

namespace App\DataFixtures;

use App\Entity\Card;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class CardFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {

        $row = 0;
        $handle = fopen("assets/data/card.csv", 'r');
        if ($handle) {
            while (($data = fgetcsv($handle, null, ';'))) {
                if ($row > 0) {

                    $rule = [
                        'type' => $data[5], 'category' => $data[6], 'value' => intval($data[7]), 'exception' => intval($data[8])
                    ];

                    $card = new Card();
                    $card->setType($data[0]);
                    $card->setName($data[1]);
                    $card->setDescription($data[2]);
                    $card->setImage($data[3]);
                    $card->setRule(json_decode($data[4], true));
                    //$card->setRule($rule);
                    $manager->persist($card);
                }


                $row++;
            }
            fclose($handle);
        }

        $manager->flush();
    }
}
