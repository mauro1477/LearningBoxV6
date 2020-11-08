<?php

namespace App\Controller;
use App\Entity\Calendar;
use App\Entity\CategoryReference;
use App\Service\UploaderHelper;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\HttpFoundation\HeaderUtils;

class CategoryReferenceAdminController extends BaseController
{
    /**
     * @Route("/admin/calendar/{id}/files", name="admin_category_add_files", methods={"POST"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function uploadCategoryReference(Calendar $calendar, Request $request, UploaderHelper $uploaderHelper, EntityManagerInterface $entityManager, ValidatorInterface $validator)
    {
        /** @var UploadedFile $uploadedFile */
        $uploadedFile = $request->files->get('file_reference');
        $violations = $validator->validate(
            $uploadedFile,
            [
                new NotBlank([
                    'message' => "Please select a file to upload"
                ]),
                new File([
                    'maxSize' => '5M',
                    'mimeTypes' => [
                        'application/pdf',
                    ]
                ])
            ]
        );

        if ($violations->count() > 0) {
            return $this->json($violations, 400);

        }

        $filename = $uploaderHelper->uploadCategoryFile($uploadedFile);
        $categoryReference = new CategoryReference($calendar);
        $categoryReference->setFilename($filename);
        $categoryReference->setOriginalFilename($uploadedFile->getClientOriginalName() ?? $filename);
        $categoryReference->setMimeType($uploadedFile->getMimeType() ?? 'application/octet-stream');
        $entityManager->persist($categoryReference);
        $entityManager->flush();
        return $this->json(
            $categoryReference,
            201,
            [],
            [
                'groups' => ['main']
            ]
        );

    }

    /**
     * @Route("/admin/calendar/references/{id}/download", name="admin_calendar_download_reference", methods={"GET"})
     */
    public function downloadCategoryReference(CategoryReference $reference, UploaderHelper $uploaderHelper)
    {
        $calendar = $reference->getCalendar();
        $this->denyAccessUnlessGranted('ROLE_USER', $calendar);
        $response = new StreamedResponse(function() use ($reference, $uploaderHelper) {
            $outputStream = fopen('php://output', 'wb');
            $fileStream = $uploaderHelper->readStream($reference->getFilePath(), false);

            stream_copy_to_stream($fileStream, $outputStream);
        });
        $disposition = HeaderUtils::makeDisposition(
            HeaderUtils::DISPOSITION_ATTACHMENT,
            $reference->getOriginalFilename()
        );
        $response->headers->set('Content-Disposition', $disposition);

        return $response;
    }

    /**
     * @Route("/admin/calendar/{id}/references", methods="GET", name="admin_calendar_list_references")
     *
     */
    public function getCategoryReferences(Calendar $calendar)
    {

        return $this->json(
            $calendar->getCategoryReferences(),
            200,
            [],
            [
                'groups' => ['main']
            ]
        );
    }

    /**
     * @Route("/admin/calendar/references/{id}", name="admin_calendar_delete_reference", methods={"DELETE"})
     */
    public function deleteCategoryReference(CategoryReference $reference,UploaderHelper $uploaderHelper, EntityManagerInterface $entityManager)
    {
        $calendar = $reference->getCalendar();
        $this->denyAccessUnlessGranted('ROLE_ADMIN', $calendar);
        $entityManager->remove($reference);
        $entityManager->flush();
        $uploaderHelper->deleteFile($reference->getFilePath(), false);

        return new Response(null, 204);

    }

    /**
     * @Route("/admin/calendar/references/{id}", name="admin_calendar_update_reference", methods={"PUT"})
     */
    public function updateCategoryReference(CategoryReference $reference, UploaderHelper $uploaderHelper, EntityManagerInterface $entityManager, SerializerInterface $serializer, Request $request, ValidatorInterface $validator)
    {
        $calendar = $reference->getCalendar();
        $this->denyAccessUnlessGranted('ROLE_ADMIN', $calendar);

        $serializer->deserialize(
            $request->getContent(),
            CategoryReference::class,
            'json',
            [
                'object_to_populate' => $reference,
                'groups' => ['input']
            ]
        );

        $violations = $validator->validate($reference);
        if ($violations->count() > 0) {
            return $this->json($violations, 400);
        }

        $entityManager->persist($reference);
        $entityManager->flush();

        return $this->json(
            $reference,
            200,
            [],
            [
                'groups' => ['main']
            ]
        );
    }

    /**
     * @Route("/admin/calendar/{id}/references/reorder", methods="POST", name="admin_calendar_reorder_references")
     * @IsGranted("ROLE_ADMIN")
     */
    public function reorderCategoryReferences(Calendar $calendar, Request $request, EntityManagerInterface $entityManager)
    {
        $orderedIds = json_decode($request->getContent(), true);
        if ($orderedIds === null) {
            return $this->json(['detail' => 'Invalid body'], 400);
        }
        // from (position)=>(id) to (id)=>(position)
        $orderedIds = array_flip($orderedIds);
        foreach ($calendar->getCategoryReferences() as $reference) {
            $reference->setPosition($orderedIds[$reference->getId()]);
        }
        $entityManager->flush();
        return $this->json(
            $calendar->getCategoryReferences(),
            200,
            [],
            [
                'groups' => ['main']
            ]
        );

    }
}