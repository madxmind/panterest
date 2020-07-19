<?php

namespace App\Form;

use App\Entity\Pin;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;

class PinType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('imageFile', VichImageType::class, [
                'label' => 'Image (JNG or PNG file)',
                'required' => false,
                'allow_delete' => true,
                // 'download_label' => 'Télécharger',
                'download_uri' => false,
                // 'image_uri' => true,
                // 'imagine_pattern' => '...',
                // 'asset_helper' => true,
            ])
            ->add('title')
            ->add('description');
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Pin::class,
        ]);
    }
}
