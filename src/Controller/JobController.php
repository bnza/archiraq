<?php

namespace App\Controller;

use Bnza\JobManagerBundle\Exception\JobManagerEntityNotFoundException;
use Bnza\JobManagerBundle\ObjectManager\ObjectManagerInterface;
use Bnza\JobManagerBundle\Serializer\JobConverter;
use Bnza\JobManagerBundle\Runner\Job\JobInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use App\Runner\Job\FullImportPublishedSitesZipShapefileJob;
use App\Runner\Job\FullImportRemoteSensingZipShapefileJob;
use App\Runner\Job\ImportFileJobFactory;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;

class JobController
{
    use JsonResponseControllerTrait;

    /**
     * @var ObjectManagerInterface
     */
    private $om;

    protected function getContributeFile(Request $request): UploadedFile
    {
        $file = $request->files->get('contribute');

        if (empty($file)) {
            $this->setStatusCode(422);
            $this->respondWithErrors('No file specified');
        }

        return $file;
    }

    protected function runJob(JobInterface $job)
    {
        try {
            $job->run();
            return $this->respond('done');
        } catch (\Exception $e) {
            $this->setStatusCode(500);
            return $this->respondWithErrors($e->getMessage());
        }
    }

    public function __construct(
        ObjectManagerInterface $om
    ) {
        $this->om = $om;
    }

    public function generateId()
    {
        return $this->respond(bin2hex(random_bytes(20)));
    }

    public function fullImportPublishedSitesZipShapefile(
        Request $request,
        ImportFileJobFactory $factory,
        AuthorizationCheckerInterface $checker,
        SessionInterface $session,
        string $id
    ) {
        if (!$checker->isGranted('ROLE_EDITOR')) {
            $this->setStatusCode(403);
            $this->respondWithErrors('Access Denied.');
        }
        $file = $this->getContributeFile($request);
        $job = $factory->create(FullImportPublishedSitesZipShapefileJob::class, $id);
        $job->setSourceZipShapefilePath($file->getPathname());
        // Symfony doesn't allow concurrent session requests so session must be close as soon as possible
        // https://stackoverflow.com/questions/47911808/symfony-not-serving-concurrent-requests
        $session->save();
        return $this->runJob($job);
    }

    public function fullImportRemoteSensingSitesZipShapefile(
        Request $request,
        ImportFileJobFactory $factory,
        AuthorizationCheckerInterface $checker,
        SessionInterface $session,
        string $id
    ) {
        if (!$checker->isGranted('ROLE_EDITOR')) {
            $this->setStatusCode(403);
            $this->respondWithErrors('Access Denied.');
        }
        $file = $this->getContributeFile($request);
        $job = $factory->create(FullImportRemoteSensingZipShapefileJob::class, $id);
        $job->setSourceZipShapefilePath($file->getPathname());
        $session->save();
        return $this->runJob($job);
    }

    public function getContributeRemoteSensingDraftError(
        Request $request,
        AuthorizationCheckerInterface $checker,
        string $id
    ) {
        try {
            if (!$checker->isGranted('ROLE_EDITOR')) {
                $this->setStatusCode(403);
                $this->respondWithErrors('Access Denied.');
            }
            $job = $this->om->find('job', $id);
            $path = $this->om->getEntityPath($job, true).'/../validationErrors.csv';
            $response = new BinaryFileResponse($path);
            // Set content disposition inline of the file
            $response->setContentDisposition(
                ResponseHeaderBag::DISPOSITION_ATTACHMENT
            );
            $response->headers->set('Content-Type', 'text/csv');
            return $response;
        } catch (JobManagerEntityNotFoundException $e) {
            $this->setStatusCode(404);
            return $this->respondWithErrors($e->getMessage());
        }
    }

    public function getJobStatus(string $id)
    {
        try {
            $job = $this->om->find('job', $id);
        } catch (JobManagerEntityNotFoundException $e) {
            $this->setStatusCode(404);
            return $this->respondWithErrors($e->getMessage());
        }

        $converter = new JobConverter();
        return $this->respond($converter->normalize($job));
    }
}
