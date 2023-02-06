<?php

namespace App\Form;

use App\Entity\Categorie;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CategorieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')

            ->add('parent', EntityType::class, [
                "class" => Categorie::class,
                "choice_label" => "nom",
                "placeholder" => "",                
                "required" => false,
                // 'query_builder' => function (EntityRepository $er) {
                //     return $er->createQueryBuilder('p')
                //         ->where('p.isParent', true)
                //          ->getQuery()
                //         ->getResult();
                // },
                
            ]);

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Categorie::class,
        ]);
    }
}
