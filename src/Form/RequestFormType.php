<?php

namespace App\Form;

use App\Entity\RequestEntity;
use App\Enum\CryptoType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RequestFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('address',TextType::class)
            ->add('asset',ChoiceType::class, [
                'choices'  => [
                    CryptoType::BTC->value,
                    CryptoType::ETH->value,
            ]])
            ->add('date_from', DateTimeType::class,
                [
                    'widget' => 'single_text',
                    'html5' => false,
                    'format' => 'd/m/Y'
            ])
            ->add('date_to', DateTimeType::class,
                [
                    'widget' => 'single_text',
                    'html5' => false,
                    'format' => 'd/m/Y'
            ])
            ->add('threshold', IntegerType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => RequestEntity::class,
        ]);
    }
}
