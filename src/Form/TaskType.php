<?php

namespace App\Form;

use App\Entity\Projects;
use App\Entity\Tasks;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TaskType extends AbstractType
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name',TextType::class,[
                'label' => "Nom de la tache: "
            ])
            ->add('startAt',null,[
                'label' => "Date de début"
            ])
            ->add('endAt',null,[
                'label' => "Date de fin"
            ])
            ->add('isInvoiced',null ,[
                'label' => "facturé: "
            ])
            ->add('project', EntityType::class, [
                'label' => "Projet: ",
                'class' => Projects::class,
                'choices' => $this->em->getRepository(Projects::class)->findall(),
                'choice_value' => function (?Projects $projects) {
                    return $projects ? $projects->getId() : "";
                },
                'choice_label' => function (?Projects $projects) {
                    return $projects ? $projects->getName() : "";
                }
            ]);
    }
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Tasks::class,
        ]);
    }
}
