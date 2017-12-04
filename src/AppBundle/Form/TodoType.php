<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

use AppBundle\Entity\Todo;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class TodoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $years = range(date('Y'), date('Y')+2);

        $builder
            ->add('name', TextType::class)
            ->add('description', TextareaType::class)
            ->add('priority', ChoiceType::class, array('choices' => array(
                    'Low' => 'Low',
                    'Medium' => 'Medium',
                    'High' => 'High',
                )))
            ->add('due_date', DateTimeType::class, array(
                'widget' => 'choice',
                'date_format' => \IntlDateFormatter::LONG, 
                'years' => $years,
                'with_minutes' => false,
                ))
        ;
    }

    public function configurateOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Todo::class,
            'arrt' => array('class' => 'hacacare')
        ));
    }
}