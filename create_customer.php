<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Simple validation (You can enhance this based on your requirements)
    $name = $_POST['name'] ?? null;
    $email = $_POST['email'] ?? null;
    $mobile = $_POST['mobile'] ?? null;
    $dob = $_POST['dob'] ?? null;
    $age = $_POST['age'] ?? null;
    $gender = $_POST['gender'] ?? null;
    $marriage_status = $_POST['marriage_status'] ?? null;
    $country_id = (string) $_POST['country_id'] ?? null;
$state_id = (string) $_POST['state_id'] ?? null;
$city_id = (string) $_POST['city_id'] ?? null;
    $image = null;

    // Validate required fields
    if (!$name || !$email || !$mobile || !$dob || !$age || !$gender) {
        echo json_encode(['code' => 400, 'status' => 'failure', 'message' => 'Missing required fields']);
        exit;
    }

    // Image upload handling
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES['image']['name']);
        if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
            $image = $target_file;
        }
    }

    // Prepare SQL query
    $query = "INSERT INTO Customers (name, email, mobile, dob, age, gender, marriage_status, country_id, state_id, city_id) 
              VALUES (:name, :email, :mobile, :dob, :age, :gender, :marriage_status, :country_id, :state_id, :city_id)";
    $stmt = $conn->prepare($query);

    // Bind parameters
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':mobile', $mobile);
    $stmt->bindParam(':dob', $dob);
    $stmt->bindParam(':age', $age);
    $stmt->bindParam(':gender', $gender);
    $stmt->bindParam(':marriage_status', $marriage_status);
    $stmt->bindParam(':country_id', $country_id, PDO::PARAM_INT);
$stmt->bindParam(':state_id', $state_id, PDO::PARAM_INT);
$stmt->bindParam(':city_id', $city_id, PDO::PARAM_INT);
    
    // // Handle image param
    // if ($image) {
    //     $stmt->bindParam(':image', $image);
    // } else {
    //     $stmt->bindValue(':image', null, PDO::PARAM_NULL); // If no image uploaded, set it to null
    // }

    try {
        // Execute query
        if ($stmt->execute()) {
            echo json_encode(['code' => 200, 'status' => 'success', 'message' => 'Customer created successfully']);
        } else {
            echo json_encode(['code' => 500, 'status' => 'failure', 'message' => 'Customer creation failed']);
        }
    } catch (PDOException $e) {
        // Handle database errors
        echo json_encode(['code' => 500, 'status' => 'failure', 'message' => 'Database error: ' . $e->getMessage()]);
    }
}
?>
