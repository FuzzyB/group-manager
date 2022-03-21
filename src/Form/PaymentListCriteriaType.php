<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PaymentListCriteriaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('sortByColumn', ChoiceType::class, [
                'choices'  => [
                    'employeeName' => 'employeeName',
                    'employeeSurname' => 'employeeSurname',
                    'departmentName' => 'departmentName',
                    'bonusSalary' => 'bonusSalary',
                    'salaryBonusType' => 'salaryBonusType',
                    'salary' => 'salary',
                ],
                'label' => 'Sort by:'
                ])
            ->add('orderType', ChoiceType::class, [
                'choices' => [
                    'asc' => 'ASC',
                    'desc' => 'DESC',
                ]
            ])
            ->add('filterByColumn', ChoiceType::class, [
                'choices'  => [
                    'departmentName' => 'departmentName',
                    'employeeName' => 'employeeName',
                    'employeeSurname' => 'employeeSurname'
                ],
            ])
            ->add('filterText', TextType::class, [
                'required' => false,
            ])
            ->add('filter', SubmitType::class, [
                'label' => 'Show result'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([]);
    }
}
