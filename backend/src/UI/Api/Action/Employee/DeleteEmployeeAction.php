<?php

declare(strict_types=1);

namespace UI\Api\Action\Employee;

use Component\Employee\Model\EmployeeId;
use Component\Employee\Module\EmployeeModuleInterface;
use OpenApi\Attributes\Delete;
use OpenApi\Attributes\Examples;
use OpenApi\Attributes\JsonContent;
use OpenApi\Attributes\Parameter;
use OpenApi\Attributes\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Uid\UuidV4;
use UI\Api\Response\Employee\DeleteEmployeeResponse;

#[Delete(
    operationId: 'DeleteEmployee',
    description: 'Delete employee',
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
            response: 204,
            description: 'Success response',
            content: new JsonContent([
                'example 1' => new Examples('Example 1', 'Success response', value: ''),
                'example 2' => new Examples('Example 2', 'Error response', value: '{"error": "HTTP header Accept is required. Supported values: application/json", "code":400}'),
            ]),
        ),
    ],
)]
#[Route(
    '/api/employee/{id}',
    name: 'app.employee.delete',
    options: ['expose' => true],
    methods: ['DELETE'],
)]
final readonly class DeleteEmployeeAction
{
    public function __construct(
        private EmployeeModuleInterface $employeeModule,
    ) {
    }

    public function __invoke(UuidV4 $id): DeleteEmployeeResponse
    {
        $this->employeeModule->delete(new EmployeeId($id));

        return new DeleteEmployeeResponse();
    }
}
