<?php

declare(strict_types=1);

namespace UI\Api\Action\Employee;

use Component\Employee\Module\EmployeeModuleInterface;
use OpenApi\Attributes\Get;
use OpenApi\Attributes\Parameter;
use OpenApi\Attributes\Response;
use Symfony\Component\Routing\Annotation\Route;
use UI\Api\Request\Employee\ListOfEmployeesRequest;
use UI\Api\Response\Employee\ListOfEmployeesResponse;

#[Get(
    operationId: 'ListOfEmployees',
    description: 'List of employees',
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
    '/api/employee',
    name: 'app.employee.list',
    options: ['expose' => true],
    methods: ['GET'],
)]
final readonly class ListOfEmployeesAction
{
    public function __construct(
        private EmployeeModuleInterface $employeeModule,
    ) {
    }

    public function __invoke(ListOfEmployeesRequest $request): ListOfEmployeesResponse
    {
        return new ListOfEmployeesResponse($this->employeeModule->findAll($request->filters()));
    }
}
