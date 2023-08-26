<?php

declare(strict_types=1);

namespace UI\Api\Action\Employee;

use Component\Employee\Dto\UpdateDto;
use Component\Employee\Model\EmployeeId;
use Component\Employee\Module\EmployeeModuleInterface;
use OpenApi\Attributes\Examples;
use OpenApi\Attributes\JsonContent;
use OpenApi\Attributes\Parameter;
use OpenApi\Attributes\Patch;
use OpenApi\Attributes\Property;
use OpenApi\Attributes\RequestBody;
use OpenApi\Attributes\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Uid\UuidV4;
use UI\Api\Request\Employee\UpdateEmployeeRequest;
use UI\Api\Response\Employee\UpdateEmployeeResponse;

#[Patch(
    operationId: 'UpdateEmployee',
    description: 'Update employee',
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
                    value: '{"address": "new-address", "country":"new-country", "var_number":"new-vat-number", "number":"new--number", "iban":"new-iban", "swift": "asfaf", "bank_name":"bank-name", "bank_address":"bank-address"}',
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
    '/api/employee/{id}',
    name: 'app.employee.update',
    options: ['expose' => true],
    methods: ['PATCH'],
)]
final readonly class UpdateEmployeeAction
{
    public function __construct(
        private EmployeeModuleInterface $employeeModule,
    ) {
    }

    public function __invoke(UuidV4 $id, #[MapRequestPayload] UpdateEmployeeRequest $request): UpdateEmployeeResponse
    {
        return UpdateEmployeeResponse::fromModel(
            $this->employeeModule->update(
                new EmployeeId($id),
                new UpdateDto(
                    $request->firstName,
                    $request->lastName,
                    $request->money(),
                )
            )
        );
    }
}
