<?php

namespace AllocMaria\FrontOfficeBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType ;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class AdherentType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        //$builder->add('sexeAdherent', ChoiceType::class, ['choices'  => ['Homme' => true, 'Femme' => false]])->add('nomAdherent', TextType::class)->add('prenomAdherent', TextType::class)->add('adresseAdherent', TextType::class)->add('codePostalAdherent', TextType::class)->add('villeAdherent', TextType::class)->add('dateNaissanceAdherent', BirthdayType::class, ['placeholder' => ['year' => 'Année', 'month' => 'Mois', 'day' => 'Jour']]);
        $builder->add('sexeAdherent', ChoiceType::class, ['choices'  => ['Homme' => true, 'Femme' => false]])->add('nomAdherent', TextType::class, ['attr' => ['placeholder' => 'Nom']])->add('prenomAdherent', TextType::class, ['attr' => ['placeholder' => 'Prénom']])->add('adresseAdherent', TextType::class, ['attr' => ['placeholder' => 'Adresse']])->add('codePostalAdherent', TextType::class, ['attr' => ['placeholder' => 'Code Postal']])->add('villeAdherent', TextType::class, ['attr' => ['placeholder' => 'Ville']])->add('dateNaissanceAdherent', DateType::class, ['widget' => 'single_text', 'format' => 'yyyy-MM-dd']);
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AllocMaria\FrontOfficeBundle\Entity\Adherent'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'allocmaria_frontofficebundle_adherent';
    }


}
