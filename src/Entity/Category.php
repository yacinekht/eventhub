<?php

namespace App\Entity;
use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Table;
use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\Validator\Constraints as Assert;
#[Entity(repositoryClass: CategoryRepository::class)]
#[Table(name:'category')]
class Category
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;
    #[Column(name:'name',type:'string',nullable: false, unique:true)]
    #[Assert\Type('string'), Assert\NotBlank()]
    private string $name;
    #[Column(name:'slug', type:'string', nullable: false , unique:true)]
    #[Assert\NotBlank(), Assert\Type('string')]
    private string $slug;

    #[ORM\OneToMany(mappedBy: 'category', targetEntity: Event::class)]
    private Collection $events;

    public function __construct()
    {
        $this->events = new ArrayCollection();
    }

    public function getname(){
        return $this->name;
    }

    public function setname($newname){
        $this->name=$newname;
    }
    public function getslug(){
        return $this->slug;
    }

    public function setslug($newslug){
        $this->slug=$newslug;
    }
    public function getId(): ?int
    {
        return $this->id;
    }

}
