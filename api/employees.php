<?php
session_start();
require_once '../classes/Employee.php';

// Set JSON headers
header('Content-Type: application/json');
header('Accept: application/json');

// Check if user is logged in and is admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    http_response_code(403);
    echo json_encode(['error' => 'Unauthorized']);
    exit();
}

$employee = new Employee();
$response = ['success' => false];

try {
    switch ($_SERVER['REQUEST_METHOD']) {
        case 'GET':
            if (isset($_GET['id'])) {
                $employeeData = $employee->getById($_GET['id']);
                if ($employeeData) {
                    $response = ['success' => true, 'employee' => $employeeData];
                } else {
                    throw new Exception('Employee not found');
                }
            } else {
                $employees = $employee->getAllEmployees();
                $response = ['success' => true, 'employees' => $employees];
            }
            break;

        case 'POST':
            $input = file_get_contents('php://input');
            error_log('Raw input: ' . $input);
            
            $data = json_decode($input, true);
            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new Exception('Invalid JSON data: ' . json_last_error_msg());
            }
            
            error_log('Received employee data: ' . print_r($data, true));
            
            // Validate input
            $errors = $employee->validateNewEmployee($data);
            error_log('Validation errors: ' . print_r($errors, true));
            
            if (empty($errors)) {
                $employeeId = $employee->create($data);
                error_log('Created employee with ID: ' . $employeeId);
                if ($employeeId) {
                    $response = [
                        'success' => true,
                        'message' => 'Employee created successfully',
                        'employeeId' => $employeeId
                    ];
                } else {
                    throw new Exception('Failed to create employee');
                }
            } else {
                $response = [
                    'success' => false,
                    'errors' => $errors
                ];
            }
            break;

        case 'PUT':
            $data = json_decode(file_get_contents('php://input'), true);
            if (!isset($data['id'])) {
                throw new Exception('Employee ID is required');
            }

            $id = $data['id'];
            unset($data['id']); // Remove id from update data

            if ($employee->update($id, $data)) {
                $response = [
                    'success' => true,
                    'message' => 'Employee updated successfully'
                ];
            } else {
                throw new Exception('Failed to update employee');
            }
            break;

        case 'DELETE':
            if (!isset($_GET['id'])) {
                throw new Exception('Employee ID is required');
            }

            if ($employee->delete($_GET['id'])) {
                $response = [
                    'success' => true,
                    'message' => 'Employee deleted successfully'
                ];
            } else {
                throw new Exception('Failed to delete employee');
            }
            break;

        default:
            throw new Exception('Method not allowed');
    }
} catch (Exception $e) {
    error_log('Error in employees.php: ' . $e->getMessage());
    $response = [
        'success' => false,
        'message' => $e->getMessage()
    ];
    http_response_code(400);
}

echo json_encode($response);
