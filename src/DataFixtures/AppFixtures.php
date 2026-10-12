<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Event;
use App\Entity\Registration;
use App\Entity\User;
use App\Enum\EventStatus;
use App\Enum\RegistrationStatus;
use App\Enum\RoleUser;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    public function __construct(
        private readonly UserPasswordHasherInterface $hasher
    ) {
    }

    public function load(ObjectManager $manager): void
    {
        // USERS
        $this->user($manager, 'admin', 'admin@eventhub.test', 'azerty', [RoleUser::Admin]);
        $organizer = $this->user($manager, 'organizer', 'organizer@eventhub.test', 'azerty', [RoleUser::Organisateur]);
        $user = $this->user($manager, 'user', 'user@eventhub.test', 'azerty', [RoleUser::Utilisateur]);

        $participants = [$user];
        for ($i = 1; $i <= 10; $i++) {
            $participants[] = $this->user(
                $manager,
                'participant' . $i,
                'participant' . $i . '@eventhub.test',
                'azerty',
                [RoleUser::Utilisateur]
            );
        }

        // CATEGORIES
        $tech  = $this->category($manager, 'Tech', 'tech');
        $sport = $this->category($manager, 'Sport', 'sport');
        $music = $this->category($manager, 'Music', 'music');

        // EVENTS
        $event1 = $this->event($manager, 'Symfony Conference', 'symfony-conference', 'Evenement Symfony', $organizer, $tech, EventStatus::Published);
        $event2 = $this->event($manager, 'Tournoi FIFA', 'tournoi-fifa', 'Competition e-sport', $organizer, $sport, EventStatus::Draft);
        $event3 = $this->event($manager, 'Concert Jazz', 'concert-jazz', 'Concert live', $organizer, $music, EventStatus::Published);

        // REGISTRATIONS
        // Symfony Conference : 11 inscrits avec des statuts variés
        foreach ($participants as $index => $participant) {
            $status = match (true) {
                $index === 9  => RegistrationStatus::Cancelled,
                $index >= 7   => RegistrationStatus::Waitlist,
                default       => RegistrationStatus::Confirmed,
            };

            $this->registration($manager, $participant, $event1, $status);
        }

        // Concert Jazz : les 6 premiers, tous confirmés
        foreach (array_slice($participants, 0, 6) as $participant) {
            $this->registration($manager, $participant, $event3);
        }

        // Pas d'inscription sur $event2 (Draft)

        $manager->flush();
    }

    private function user(ObjectManager $manager, string $username, string $email, string $password, array $roles): User
    {
        $user = new User();

        $user->setUsername($username);
        $user->setEmail($email);
        $user->setRoles($roles);
        $user->setPassword($this->hasher->hashPassword($user, $password));

        $manager->persist($user);

        return $user;
    }

    private function registration(
        ObjectManager $manager,
        User $user,
        Event $event,
        RegistrationStatus $status = RegistrationStatus::Confirmed
    ): Registration {
        $registration = new Registration($status);

        $registration->setUser($user);
        $registration->setEvent($event);
        $registration->setCreatedAt(new \DateTimeImmutable());

        $manager->persist($registration);

        return $registration;
    }

    private function category(ObjectManager $manager, string $name, string $slug): Category
    {
        $category = new Category();

        $category->setName($name);
        $category->setSlug($slug);

        $manager->persist($category);

        return $category;
    }

    private function event(
        ObjectManager $manager,
        string $title,
        string $slug,
        string $description,
        User $organizer,
        Category $category,
        EventStatus $status
    ): Event {
        $event = new Event();

        $event->setTitle($title);
        $event->setSlug($slug);
        $event->setDescription($description);
        $event->setOrganizer($organizer);
        $event->setCategory($category);
        $event->setStatus($status);

        $event->setCapacity(100);
        $event->setCoverImage('default.jpg');

        $event->setStartAt(new \DateTimeImmutable('+7 days'));
        $event->setEndAt(new \DateTimeImmutable('+7 days +2 hours'));

        $manager->persist($event);

        return $event;
    }
}
