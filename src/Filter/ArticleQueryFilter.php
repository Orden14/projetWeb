<?php

namespace App\Filter;

use Doctrine\ORM\QueryBuilder;
use ApiPlatform\Metadata\Operation;
use Symfony\Component\PropertyInfo\Type;
use ApiPlatform\Doctrine\Orm\Filter\AbstractFilter;
use ApiPlatform\Doctrine\Orm\Util\QueryNameGeneratorInterface;

class ArticleQueryFilter extends AbstractFilter
{
    /**
     * @param array<string, mixed> $context
     */
    protected function filterProperty(
        string $property,
        mixed $value,
        QueryBuilder $queryBuilder,
        QueryNameGeneratorInterface $queryNameGenerator,
        string $resourceClass,
        Operation $operation = null,
        array $context = []
    ): void
    {
        if ($property !== 'query') {
            return;
        }

        $alias = $queryBuilder->getRootAliases()[0];

        $queryBuilder
            ->andWhere(sprintf('%s.title LIKE :query OR %s.description LIKE :query', $alias, $alias))
            ->setParameter('query', '%' . $value . '%')
        ;
    }

    /**
     * @return array<string, mixed>
     */
    public function getDescription(string $resourceClass): array
    {
        return [
            'query' => [
                'property' => 'query',
                'type' => Type::BUILTIN_TYPE_STRING,
                'required' => false,
                'description' => 'Filter articles by title or description',
                'openapi' => [
                    'allowedReserved' => false,
                    'allowEmptyValue' => true,
                    'explode' => false,
                ],
            ],
        ];
    }
}