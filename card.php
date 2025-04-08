<?php
$courses = getCoursesWithInstructors($conn);
?>

<?php if (empty($courses)): ?>
    <div class="col-12 text-center my-5">
        <div class="no-courses-found">
            <h3>No Courses Found</h3>
            <p>We currently don't have any active courses available. Please check back later!</p>
        </div>
    </div>
<?php else: ?>
    <?php foreach ($courses as $course): ?>
        <div class="col-12 col-md-12 col-lg-6 col-xl-4 mb-4">
            <div class="course-card">
                <div class="card-header">
                    <div class="image-container">
                        <img src="<?php echo htmlspecialchars($course['photo']); ?>"
                            class="course-thumbnail"
                            alt="<?php echo htmlspecialchars($course['name']); ?>"
                            loading="lazy">
                        <?php if ($course['badge']): ?>
                            <div class="card-badges">
                                <span class="popular-badge">
                                    <i class="fas fa-charge me-1"></i><?php echo htmlspecialchars($course['badge']); ?>
                                </span>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="card-body">
                    <div class="meta-header">
                        <span class="edition-pill"><?php echo htmlspecialchars($course['edition']); ?></span>
                        <div class="rating">
                            <i class="fas fa-star"></i> <?php echo number_format($course['rating'], 1); ?>
                        </div>
                    </div>
                    <h3 class="course-title"><?php echo htmlspecialchars($course['name']); ?></h3>

                    <!-- Instructors Section -->
                    <div class="instructors">
                        <div class="avatar-stack">
                            <?php
                            $instructorCount = count($course['instructor_names']);
                            $visibleInstructors = array_slice($course['instructor_names'], 0, 4);
                            foreach ($visibleInstructors as $index => $instructor): ?>
                                <div class="avatar">
                                    <img src="<?php echo htmlspecialchars($course['instructor_photos'][$index] ?? 'default-avatar.jpg'); ?>"
                                        alt="<?php echo htmlspecialchars($instructor); ?>">
                                </div>
                            <?php endforeach; ?>
                            <?php if ($instructorCount > 4): ?>
                                <div class="avatar hidden-avatar">
                                    +<?php echo $instructorCount - 4; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="instructor-names">
                            <span><?php echo htmlspecialchars(implode(', ', $course['instructor_names'])); ?></span>
                        </div>
                    </div>

                    <div class="course-stats p-2 d-flex justify-content-between align-items-center">
                        <div class="stat-item">
                            <i class="far fa-clock"></i>
                            <span><?php echo $course['duration_months']; ?> Month<?php echo $course['duration_months'] > 1 ? 's' : ''; ?></span>
                        </div>
                        <div class="stat-item">
                            <i class="fas fa-chalkboard-teacher"></i>
                            <span><?php echo $course['num_classes']; ?> Classes</span>
                        </div>
                        <div class="stat-item">
                            <i class="fas fa-file-alt"></i>
                            <span><?php echo $course['num_exams']; ?> Exams</span>
                        </div>
                    </div>
                </div>
                <div class="card-footer d-flex justify-content-between">
                    <div class="price-container flex-column">
                        <div class="original-price">৳<?php echo number_format($course['original_price'], 0); ?></div>
                        <div class="discounted-price">৳<?php echo number_format($course['discounted_price'], 0); ?></div>
                    </div>
                    <div>
                        <a class="enroll-button" href="<?php echo BASE_PATH; ?>/course/view/<?php echo htmlspecialchars($course['slug']); ?>/">
                            Enroll Now
                            <i class="fas fa-arrow-right-long"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
<?php endif; ?>

<?php
$conn->close();
?>