<?php

namespace App\Form;

use App\Entity\Company;
use App\Enum\CompanyService;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CompanyEditType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, ['label' => 'Nom'])
            ->add('isProvider', CheckboxType::class, ['label' => 'Fournisseur'])
            ->add('isManufacturer', CheckboxType::class, ['label' => 'Fabricant'])
            ->add(
                'service',
                ChoiceType::class,
                [
                    'label' => 'Service',
                    'help' => 'Type de service fourni par cette companie',
                    'choices' => CompanyService::getFormChoices()
                ]
            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Company::class,
        ]);
    }
}
