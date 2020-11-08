<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\Calendar;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Repository\CalendarRepository;
use Symfony\Component\Validator\Constraints\Image;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class CalendarFormType extends AbstractType
{
    private $calendarRepository;

    public function __construct(CalendarRepository  $calendarRepository)
    {
        $this->calendarRepository = $calendarRepository;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        /** @var  Calendar|null $calendar */
        $calendar = $options['data'] ?? null;
        $isEdit = $calendar && $calendar->getId();

        $builder
            ->add('title', TextType::class,[
                'label' => 'Day title'
            ])
            ->add('content',TextType::class, [
                'label' => 'Daily Notes'
            ]);


        $builder
            ->add('PublishedAt', ChoiceType::class, [
                'choices'  => [
                    'Yes' => true,
                    'No' => false,
                ],
                'placeholder' => 'Choose an option',

        ]);

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Calendar::class
        ]);
    }
}
?>