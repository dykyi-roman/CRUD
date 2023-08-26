<?php

declare(strict_types=1);

namespace UI\Api\Action\Employee;

use Component\Employee\Model\Employee;
use Component\Employee\Model\EmployeeId;
use Component\Employee\Module\EmployeeModuleInterface;
use OpenApi\Attributes\Examples;
use OpenApi\Attributes\JsonContent;
use OpenApi\Attributes\Parameter;
use OpenApi\Attributes\Post;
use OpenApi\Attributes\Property;
use OpenApi\Attributes\RequestBody;
use OpenApi\Attributes\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Annotation\Route;
use UI\Api\Request\Employee\CreateEmployeeRequest;
use UI\Api\Response\Employee\CreateEmployeeResponse;

#[Post(
    operationId: 'CreateEmployee',
    description: 'Create employee',
    requestBody: new RequestBody(
        content: new JsonContent(
            properties: [
                new Property(
                    property: 'firstName',
                    type: 'string',
                ),
                new Property(
                    property: 'lastName',
                    type: 'string',
                ),
                new Property(
                    property: 'country',
                    type: 'string',
                ),
                new Property(
                    property: 'emailAddress',
                    type: 'string',
                ),
                new Property(
                    property: 'hiringAt',
                    type: 'string',
                ),
                new Property(
                    property: 'salary',
                    type: 'integer',
                ),
                new Property(
                    property: 'currency',
                    type: 'string',
                ),
            ],
        ),
    ),
    tags: ['Employee'],
    parameters: [
        new Parameter(
            name: 'Accept',
            in: 'header',
            required: true,
            example: 'application/json',
        ),
    ],
    responses: [
        new Response(
            response: 200,
            description: 'Response example',
            content: new JsonContent([
                'example 1' => new Examples(
                    'Example 1',
                    'Success response',
                    value: '{"id": "6ba7b811-9dad-11d1-80b4-00c04fd430c8"}',
                ),
                'example 2' => new Examples(
                    'Example 2',
                    'Error response',
                    value: '{"error": "HTTP header Accept is required. Supported values: application/json", "code":400}',
                ),
            ]),
        ),
    ],
)]
#[Route(
    '/api/employee',
    name: 'app.employee.create',
    options: ['expose' => true],
    methods: ['POST'],
)]
final readonly class CreateEmployeeAction
{
    public function __construct(
        private EmployeeModuleInterface $employeeModule,
    ) {
    }

    public function __invoke(#[MapRequestPayload] CreateEmployeeRequest $request): CreateEmployeeResponse
    {
        $this->employeeModule->create(
            new Employee(
                $employeeId = new EmployeeId(),
                $request->firstName,
                $request->lastName,
                $request->emailAddress(),
                $request->money(),
                new \DateTimeImmutable($request->hiringAt),
            ),
        );

        return new CreateEmployeeResponse($employeeId);
    }
}
