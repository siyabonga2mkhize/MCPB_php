<?php
// MOCK get_profile.php
// This pretends to look up the user's full details using the email.

header("Access-Control-Allow-Origin: *");
header('Content-Type: application/json');

// --- MOCK DATA ---
$mock_profile_data = [
    'Siyabonga@test.com' => [
        'title' => 'Mr',
        'firstName' => 'Siyabonga',
        'lastName' => 'Mkhize',
        'contactNumber' => '0789898434',
        'dateOfBirth' => '1990-01-01',
        'promoWoolworths' => 1,
        'promoFinancial' => 0,
        'email' => 'Siyabonga@test.com'
    ],
    // The details for the test user who logged in:
    'test@user.com' => [ 
        'title' => 'Ms',
        'firstName' => 'Test',
        'lastName' => 'User',
        'contactNumber' => '0123456789',
        'dateOfBirth' => '1985-05-15',
        'promoWoolworths' => 1,
        'promoFinancial' => 1,
        'email' => 'test@user.com'
    ]
];

$data = json_decode(file_get_contents("php://input"), true);
$email = $data['email'] ?? '';

if (isset($mock_profile_data[$email])) {
    http_response_code(200);
    echo json_encode(['success' => true, 'data' => $mock_profile_data[$email]]);
} else {
    http_response_code(404);
    echo json_encode(['success' => false, 'message' => 'Profile not found.']);
}