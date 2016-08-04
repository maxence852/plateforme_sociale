<?php

/**
 * This file is part of the FOSCommentBundle package.
 *
 * (c) FriendsOfSymfony <http://friendsofsymfony.github.com/>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Tfe\ForumBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;


class ThreadType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {

    }
    public function getParent()
    {
        return 'FOS\CommentBundle\Form\ThreadType';

    }



    public function getBlockPrefix()
    {
        return 'fos_comment_thread';
    }

    public function getName()
    {
        return $this->getBlockPrefix();
    }
}
