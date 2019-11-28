<?php

namespace App\Repository;

use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\Criteria;
use Doctrine\Common\Persistence\ManagerRegistry;

abstract class AbstractCrudRepository extends ServiceEntityRepository
{
    /**
     * The filter QueryBuilder.
     *
     * @var QueryBuilder
     */
    private $qbf;

    /**
     * The count QueryBuilder.
     * Returns the number of item matching the filter query without offset and limit.
     *
     * @var QueryBuilder
     */
    private $qbc;

    /**
     * The entity alias.
     *
     * @var string
     */
    private $alias = 'e';

    /**
     * @var string
     */
    private $idField = 'id';

    public function __construct(ManagerRegistry $registry, string $className)
    {
        parent::__construct($registry, $className);
    }

    /**
     * @param int $id
     *
     * @return array
     *
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function findAsArray(int $id)
    {
        $qbf = $this->createFilterQueryBuilder();

        return $qbf
            ->add(
                'where',
                $qbf->expr()->eq(
                    $this->getIdFieldAlias(),
                    '?1'
                )
            )
            ->setParameter(1, $id)
            ->getQuery()
            ->getSingleResult(Query::HYDRATE_ARRAY);
    }

    /**
     * @param array $filter
     * @param array $sort
     * @param int $limit
     * @param int $offset
     * @return array
     * @throws Query\QueryException
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function findByAsArray(array $filter = [], array $sort = [], int $limit = null, int $offset = null): array
    {
        $this->createQueryBuilders($limit, $offset);
        $this->addFilters($filter);
        $this->addSortCriteria($sort);

        return $this->getListResultData();
    }

    protected function getAlias(): string
    {
        return $this->alias;
    }

    protected function getIdField(): string
    {
        return $this->idField;
    }

    /**
     * Returns the DQL id field identifier e.g. "e.id".
     *
     * @return string
     */
    protected function getIdFieldAlias(): string
    {
        return $this->getAlias().'.'.$this->getIdField();
    }

    protected function getCountQueryBuilder(): QueryBuilder
    {
        return $this->qbc;
    }

    protected function getFilterQueryBuilder(): QueryBuilder
    {
        return $this->qbf;
    }

    /**
     * Creates the count and filter query builders.
     *
     * @param null $limit  The select limit
     * @param null $offset The select offset
     */
    protected function createQueryBuilders($limit = null, $offset = null): void
    {
        $this->createFilterQueryBuilder($limit, $offset);
        $this->createCountQueryBuilder();
    }

    /**
     * Creates the count query builder.
     *
     * @return QueryBuilder
     */
    protected function createCountQueryBuilder(): QueryBuilder
    {
        $qbc = $this->qbc = $this->createQueryBuilder($this->getAlias());

        $this->qbc
            ->select(
                $qbc->expr()->count(
                    $this->getAlias()
                )
            );

        $this->addQueryBuilderLeftJoins($this->qbc);

        return $this->qbc;
    }

    /**
     * @param null $limit
     * @param null $offset
     *
     * @return QueryBuilder
     */
    protected function createFilterQueryBuilder($limit = null, $offset = null): QueryBuilder
    {
        $this->qbf = $this
            ->createQueryBuilder($this->getAlias())
            ->setFirstResult($offset)
            ->setMaxResults($limit);
        $this->addQueryBuilderSelects($this->qbf);
        $this->addQueryBuilderLeftJoins($this->qbf);

        return $this->qbf;
    }

    /**
     * Add entity specific left joins to query builder. Must be override.
     *
     * @param QueryBuilder $qb
     *
     * @return AbstractCrudRepository
     */
    protected function addQueryBuilderLeftJoins(QueryBuilder $qb): self
    {
        //TODO make method abstract
    }

    /**
     * Add entity specific select clauses to query builder. Must be override.
     *
     * @param QueryBuilder $qb
     *
     * @return AbstractCrudRepository
     */
    protected function addQueryBuilderSelects(QueryBuilder $qb): self
    {
        //TODO make method abstract
    }

    /**
     * @param array $filter
     */
    protected function addFilters(array $filter = [])
    {
        if ($filter) {
            list($expressions, $parameters) = $this->getFilterExpressions($filter);

            // Filter Query
            $this->getFilterQueryBuilder()->add('where', $expressions);
            $this->getFilterQueryBuilder()->setParameters($parameters);

            // Count Query
            $this->getCountQueryBuilder()->add('where', $expressions);
            $this->getCountQueryBuilder()->setParameters($parameters);
        }
    }

    /**
     * Translates the "filter" HTTP request query parameter into an associative array which holds the DQL expressions and
     * parameters for the QueryBuilder
     * filter is in the form
     * [
     *  "op" => "eq" //any valid Doctrine/ORM/Expr
     *  "value" => any //the filter parameter value
     *  "cast" => "bool" //cast string value to given type (only bool supported by now)
     * ]
     * @param array $filter
     * @return array The associative array which holds the DQL expressions and parameters for the query builder
     */
    protected function getFilterExpressions(array $filter): array
    {
        $expressions = [];
        $params = [];
        $i = 1;
        $noOperandOperators = [
            'isNull',
            'isNotNull',
        ];
        $qbf = $this->getFilterQueryBuilder();
        foreach ($filter as $field => $criterium) {
            // TODO check criterium operator
            $operator = $criterium['op'];
            // LEFT EXPRESSION: normalized field alias
            $le = false === strpos($field, '.')
                ? "{$this->getAlias()}.{$field}"
                : $field;

            // RIGHT OPERAND: value parameter placeholder
            $rep = ":p{$i}";

            if (in_array($operator, $noOperandOperators)) {
                $expression = $qbf->expr()->{$operator}($le);
            } else {
                $expression = $qbf->expr()->{$operator}($le, $rep);
                // TODO make method
                if (array_key_exists('cast', $criterium)) {
                    switch ($criterium['cast']) {
                        case 'bool':
                            $criterium['value'] = false == $criterium['value'] || 'false' === $criterium['value'] ? false : true;
                            break;
                    }
                }
                $params[$rep] = $criterium['value'];
            }
            $expressions[] = $expression;
            $i++;
        }

        if (count($expressions) > 1) {
            $expressions = $this->qbf->expr()->andX(
                ...$expressions
            );
        } else {
            $expressions = $expressions[0];
        }

        return [$expressions, $params];
    }

    /**
     * @param array $sort
     * @throws Query\QueryException
     */
    protected function addSortCriteria(array $sort)
    {
        if ($sort) {
            $sortCriteria = Criteria::create()
                ->orderBy($sort);
            $this->getFilterQueryBuilder()->addCriteria($sortCriteria);
        }
    }

    /**
     * @return array
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    protected function getListResultData()
    {
        $queryCount = $this->getCountQueryBuilder()->getQuery();
        $query = $this->getFilterQueryBuilder()->getQuery();

        return [
            'items' => $query->getArrayResult(),
            'totalItems' => $queryCount->getSingleScalarResult()
        ];
    }
}
