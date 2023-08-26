<?php

declare(strict_types=1);

namespace UI\Api\Action\Employee;

use Component\Employee\Model\EmployeeId;
use Component\Employee\Module\EmployeeModuleInterface;
use OpenApi\Attributes\Get;
use OpenApi\Attributes\Parameter;
use OpenApi\Attributes\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Uid\UuidV4;
use UI\Api\Response\Employee\FindEmployeeResponse;

#[Get(
    operationId: 'FindEmployee',
    description: 'Find employee',
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
            description: 'Success response',
        ),
    ],
)]
#[Route(
    '/api/employee/{id}',
    name: 'app.employee.find',
    options: ['expose' => true],
    methods: ['GET'],
)]
final readonly class FindEmployeeAction
{
    public function __construct(
        private EmployeeModuleInterface $employeeModule,
    ) {
    }

    public function __invoke(UuidV4 $id): FindEmployeeResponse
    {
        return FindEmployeeResponse::fromModel($this->employeeModule->findById(new EmployeeId($id)));
    }
}
