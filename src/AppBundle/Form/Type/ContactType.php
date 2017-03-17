<?php

namespace AppBundle\Form\Type;


use AppBundle\Entity\Contact;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class ContactType
 *
 * @package AppBundle\Form\Type
 */
class ContactType extends AbstractType
{
    /**
     * @inheritdoc
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('salutation')
            ->add('first_name', null, ['property_path' => 'firstName'])
            ->add('last_name', null, ['property_path' => 'lastName'])
            ->add('mail');
    }

    /**
     * @inheritdoc
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Contact::class,
            'csrf_protection' => false,
        ));
    }
}
