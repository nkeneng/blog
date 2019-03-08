<?php

namespace App\DataFixtures;

use App\Entity\Articles;
use App\Entity\Category;
use App\Entity\Comments;
use App\Entity\User;
use Cocur\Slugify\Slugify;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class ArticlesFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $slugify = new Slugify();
        $users = [];
        $faker = \Faker\Factory::create('fr_FR');
        for ($k = 1; $k < 5; $k++) {
            $user = new User();
            $user->setUsername($faker->name)
                ->setEmail($faker->email)
                ->setPassword('admin')
                ->setRoles($faker->randomElements($user->getRoles()));
            $manager->persist($user);
            $users[] = $user;
        }


        for ($i = 1; $i <= 3; $i++) {
            $category = new Category();
            $category->setName($faker->sentence())
                     ->setSlug($slugify->slugify($category->getName()));
            $manager->persist($category);

            for ($j = 1; $j < 5; $j++) {
                $article = new Articles();
                $content = '<p>' . join($faker->paragraphs(4), '<p></p>') . '</p>';
                $article->setTitle($faker->sentence($nbWords = 3, $variableNbWords = true))
                    ->setContent($content)
                    ->setImageName($faker->imageUrl($width = 550, $height = 380));
                $article->setCreatedAt( $faker->dateTimeBetween('-6 months'))
                         ->setUpdatedAt( $faker->dateTimeBetween('-6 months'))
                    ->setCategory($category)
                    ->setSlug($slugify->slugify($article->getTitle()))
                    ->setUser($faker->randomElement($users));
                $manager->persist($article);
                
                $content = $faker->sentence($nbWords = 6, $variableNbWords = true);
                $now = new DateTime();
                $intervall = $now->diff($article->getCreatedAt());
                $days = $intervall->days;

                for ($k = 1; $k <= mt_rand(4, 10); $k++) {
                    $comment = new Comments();
                    $comment->setAuthor($faker->randomElement($users))
                        ->setContent($content)
                        ->setCreatedAt($faker->dateTimeBetween('-' . $days . 'days'))
                        ->setArticle($article);
                    $manager->persist($comment);
                }
            }
        }
        $manager->flush();
    }
}
