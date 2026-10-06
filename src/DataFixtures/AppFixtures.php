<?php
//
//namespace App\DataFixtures;
//
//use App\Entity\User;
//use Doctrine\Bundle\FixturesBundle\Fixture;
//use Doctrine\Persistence\ObjectManager;
//use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
//
//class AppFixtures extends Fixture
//{
//    public function __construct(private readonly UserPasswordHasherInterface $hasher)
//    {
//    }
//
//    public function load(ObjectManager $manager): void
//    {
//        $this->user($manager, 'Max', 'maxencevast@gmail.com', 'azerty', ['ROLE_USER','ROLE_ADMIN']);
//        $this->user($manager, 'organizer', 'organizer@eventhub.test', 'azerty', ['ROLE_ORGANIZER']);
//        $this->user($manager, 'admin', 'admin@eventhub.test', 'azerty', ['ROLE_ADMIN']);
//        $this->user($manager, 'user', 'user@eventhub.test', 'azerty', ['ROLE_USER']);
//
//        $manager->flush();
//    }
//
//    private function user(ObjectManager $manager, string $username, string $email, string $password, array $roles): User
//    {
//        $user = new User();
//        $user->setUsername($username);
//        $user->setEmail($email);
//        $user->setRoles($roles);
//        $user->setPassword($this->hasher->hashPassword($user, $password));
//        $manager->persist($user);
//        return $user;
//    }
//}


namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Event;
use App\Entity\Category;
use App\Enum\EventStatus;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    public function __construct(
        private readonly UserPasswordHasherInterface $hasher
    )
    {
    }

    public function load(ObjectManager $manager): void
    {
        // USERS
        $admin = $this->user(
            $manager,
            'admin',
            'admin@eventhub.test',
            'azerty',
            ['ROLE_ADMIN']
        );

        $organizer = $this->user(
            $manager,
            'organizer',
            'organizer@eventhub.test',
            'azerty',
            ['ROLE_ORGANIZER']
        );

        // CATEGORIES
        $tech = $this->category($manager, 'Tech', 'tech');
        $sport = $this->category($manager, 'Sport', 'sport');
        $music = $this->category($manager, 'Music', 'music');

        // EVENTS
        $this->event($manager, 'Symfony Conference', 'symfony-conference', 'Evenement Symfony', $organizer, $tech, EventStatus::Published
        );

        $this->event($manager, 'Tournoi FIFA', 'tournoi-fifa', 'Competition e-sport', $organizer, $sport, EventStatus::Draft
        );

        $this->event($manager, 'Concert Jazz', 'concert-jazz', 'Concert live', $organizer, $music, EventStatus::Published
        );

        $manager->flush();
    }

    private function user(ObjectManager $manager, string $username, string $email,string $password, array $roles): User
    {
        $user = new User();

        $user->setUsername($username);
        $user->setEmail($email);
        $user->setRoles($roles);
        $user->setPassword(
            $this->hasher->hashPassword($user, $password)
        );

        $manager->persist($user);

        return $user;
    }

    private function category(ObjectManager $manager, string $name, string $slug): Category
    {
        $category = new Category();

        $category->setname($name);
        $category->setslug($slug);

        $manager->persist($category);

        return $category;
    }

    private function event(ObjectManager $manager, string $title, string $slug, string $description, User $organizer, Category $category, EventStatus $status): Event
    {
        $event = new Event();

        $event->setTitle($title);
        $event->setSlug($slug);
        $event->setDescription($description);
        $event->setOrganizer($organizer);
        $event->setCategory($category);
        $event->setStatus($status);

        $event->setCapacity(100);
        $event->setCoverImage('default.jpg');

        $event->setStartAt(
            new \DateTimeImmutable('+7 days')
        );

        $event->setEndAt(
            new \DateTimeImmutable('+7 days +2 hours')
        );

        $manager->persist($event);

        return $event;
    }
}
