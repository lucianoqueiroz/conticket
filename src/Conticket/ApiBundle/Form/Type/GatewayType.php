<?php
/*
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR
 * A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT
 * OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL,
 * SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT
 * LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE,
 * DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY
 * THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE
 * OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 *
 * This software consists of voluntary contributions made by many individuals
 * and is licensed under the MIT license.
 */
namespace Conticket\ApiBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\DataMapperInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Conticket\ApiBundle\Document\Gateway;

final class GatewayType extends AbstractType implements DataMapperInterface
{
    const TYPE_NAME = 'gateway';

    /**
     * {@inheritDoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text')
            ->add('type', 'text')
            ->add('key', 'text')
            ->setDataMapper($this);
    }

    /**
     * {@inheritDoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class'      => Gateway::class,
            'csrf_protection' => false,
            'empty_data'      => null,
            'multiple'        => false,
        ]);
    }

    /**
     * {@inheritDoc}
     */
    public function getName()
    {
        return static::TYPE_NAME;
    }

    /**
     * {@inheritDoc}
     */
    public function mapDataToForms($data, $forms)
    {
        if (! $data) {
            return;
        }

        $forms = iterator_to_array($forms);

        $forms['name']->setData($data->getName());
        $forms['type']->setData($data->getType());
        $forms['key']->setData($data->getKey());
    }

    /**
     * {@inheritDoc}
     */
    public function mapFormsToData($forms, &$data)
    {
        $forms = iterator_to_array($forms);

        $data = new Gateway(
            $forms['name']->getData(),
            $forms['type']->getData(),
            $forms['key']->getData()
        );
    }
}
