<?php

namespace App\Form\Event;

use App\Entity\Category;
use App\Entity\Event;
use App\Entity\User;
use App\Enum\EventStatus;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\GreaterThan;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Positive;

class EditEventType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Titre',
                'constraints' => [
                    new NotBlank(),
                    new Length(max: 255),
                ],
            ])
//            ->add('organizer', EntityType::class, [
//                'label' => 'Organisateur',
//                'class' => User::class,
//                'choice_label' => 'email',
//                'placeholder' => 'Choisir un organisateur',
//                'constraints' => [
//                    new NotBlank(),
//                ],
//            ])
            ->add('category', EntityType::class, [
                'label' => 'Catégorie',
                'class' => Category::class,
                'choice_label' => 'name',
                'placeholder' => 'Choisir une catégorie',
                'constraints' => [
                    new NotBlank(),
                ],
            ])
            ->add('status', EnumType::class, [
                'label' => 'Statut',
                'class' => EventStatus::class,
                'choice_label' => fn (EventStatus $status) => $status->value,
                'constraints' => [
                    new NotBlank(),
                ],
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description',
                'attr' => ['rows' => 6],
                'constraints' => [
                    new NotBlank(),
                ],
            ])
            ->add('startAt', DateTimeType::class, [
                'label' => 'Début',
                'widget' => 'single_text',
                'input' => 'datetime_immutable',
                'constraints' => [
                    new NotBlank(),
                ],
            ])
            ->add('endAt', DateTimeType::class, [
                'label' => 'Fin',
                'widget' => 'single_text',
                'input' => 'datetime_immutable',
                'constraints' => [
                    new NotBlank(),
                    new GreaterThan(
                        propertyPath: 'parent.all[startAt].data',
                        message: 'La fin doit être après le début.',
                    ),
                ],
            ])
            ->add('capacity', IntegerType::class, [
                'label' => 'Capacité',
                'attr' => ['min' => 1],
                'constraints' => [
                    new NotBlank(),
                    new Positive(),
                ],
            ])
            ->add('coverImage', UrlType::class, [
                'label' => "Image de couverture (URL)",
                'required' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Event::class,
        ]);
    }
}
