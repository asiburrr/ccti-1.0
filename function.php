<?php
// Function to fetch courses with instructors
function getCoursesWithInstructors($conn, $slug = null) {
    try {
        $sql = "
            SELECT 
                c.course_id,
                c.name,
                c.short_des,
                c.description,
                c.enrolled,
                c.five_star,
                c.badge,
                c.edition,
                c.duration_months,
                c.num_classes,
                c.num_exams,
                c.original_price,
                c.discounted_price,
                c.rating,
                c.photo,
                c.slug,
                cat.name as category_name,
                GROUP_CONCAT(a.full_name) as instructor_names,
                GROUP_CONCAT(a.photo) as instructor_photos
            FROM courses c
            LEFT JOIN categories cat ON c.category_id = cat.category_id
            LEFT JOIN course_instructor ci ON c.course_id = ci.course_id
            LEFT JOIN admins a ON ci.instructor_id = a.admin_id AND a.role = 'instructor'
            WHERE c.is_active = 1
        ";
        
        // Add slug condition if provided
        if ($slug !== null) {
            $sql .= " AND c.slug = ?";
        }
        
        $sql .= " GROUP BY c.course_id ORDER BY c.created_at DESC";

        if ($slug !== null) {
            // Use prepared statement for single course
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $slug);
            $stmt->execute();
            $result = $stmt->get_result();
            
            if ($result->num_rows === 0) {
                return null;
            }
            
            $course = $result->fetch_assoc();
            $course['instructor_names'] = $course['instructor_names'] ? explode(',', $course['instructor_names']) : [];
            $course['instructor_photos'] = $course['instructor_photos'] ? explode(',', $course['instructor_photos']) : [];
            return $course;
        } else {
            // Regular query for all courses
            $result = $conn->query($sql);
            
            if (!$result) {
                throw new Exception("Query failed: " . $conn->error);
            }

            $courses = [];
            while ($row = $result->fetch_assoc()) {
                $row['instructor_names'] = $row['instructor_names'] ? explode(',', $row['instructor_names']) : [];
                $row['instructor_photos'] = $row['instructor_photos'] ? explode(',', $row['instructor_photos']) : [];
                $courses[] = $row;
            }
            
            return $courses;
        }

    } catch (Exception $e) {
        error_log("Error in getCoursesWithInstructors: " . $e->getMessage());
        return ($slug !== null) ? null : [];
    }
}
// Function to check enrollment status
function getEnrollmentStatus($conn, $course_id, $user_id) {
    $sql = "SELECT is_approved FROM enrollments WHERE course_id = ? AND user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $course_id, $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->num_rows > 0 ? $result->fetch_assoc()['is_approved'] : null;
}
