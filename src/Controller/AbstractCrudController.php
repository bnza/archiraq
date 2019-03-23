<?php

namespace App\Controller;

use App\Repository\AbstractCrudRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\NoResultException;
use Doctrine\ORM\NonUniqueResultException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

abstract class AbstractCrudController extends AbstractController
{
    private $em;

    private $statusCode = 200;

    /**
     * Map the request entity name to the entity class name
     * @param $entityName
     * @return string
     */
    abstract public function getEntityClass($entityName): string;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function getEntityManager(): EntityManagerInterface
    {
        return $this->em;
    }

    /**
     * @return int
     */
    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    /**
     * @param int $statusCode
     * @return AbstractCrudController
     */
    public function setStatusCode(int $statusCode): self
    {
        $this->statusCode = $statusCode;

        return $this;
    }

    /**
     * Returns a JSON response
     *
     * @param array $data
     * @param array $headers
     *
     * @return JsonResponse
     */
    public function respond($data, $headers = [])
    {
        return new JsonResponse($data, $this->getStatusCode(), $headers);
    }

    /**
     * Sets an error message and returns a JSON response
     *
     * @param mixed $errors
     * @param array $headers
     *
     * @return JsonResponse
     */
    public function respondWithErrors($errors, $headers = [])
    {
        $data = [
            'errors' => $errors,
        ];

        return $this->respond($data, $headers);
    }

    /**
     * @param string $entityName
     * @param int    $id
     *
     * @return JsonResponse
     */
    public function read(string $entityName, int $id)
    {
        try {
            $data = $this
                ->getRepository($entityName)
                ->findAsArray($id);
        } catch (NonUniqueResultException $e) {
            return $this->setStatusCode(400)->respondWithErrors('Non unique result');
        } catch (NoResultException $e) {
            return $this->setStatusCode(401)->respondWithErrors("No item found with id $id");
        }
        return $this->respond($data);
    }

    /**
     * @param Request $request
     * @param string  $entityName
     *
     * @return JsonResponse
     */
    public function list(Request $request, string $entityName)
    {
        $pagination =  $request->get('pagination') ?: [];


        $sort = array_key_exists('sort', $pagination) ? $pagination['sort'] : [];
        $limit = array_key_exists('limit', $pagination) ? $pagination['limit'] : 10;
        $limit = $limit > 50 ? 50 : $limit;
        $offset = array_key_exists('offset', $pagination) ? $pagination['offset'] : 0;

        $filter = $request->get('filter') ?: [];

        $repo = $this->getRepository($entityName);

        try {
            $data = $repo->findByAsArray($filter, $sort, $limit, $offset);
        } catch (\Exception $e) {
            return $this->setStatusCode(400)->respondWithErrors($e->getMessage());
        }
        return $this->respond($data);

    }

    /**
     * @param $entityName
     *
     * @return AbstractCrudRepository;
     */
    protected function getRepository($entityName): AbstractCrudRepository
    {
        return $this->getEntityManager()->getRepository($this->getEntityClass($entityName));
    }




}
