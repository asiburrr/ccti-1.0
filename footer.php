<!-- File: footer.php -->
<footer class="footer text-white pt-5 pb-4" style="background: linear-gradient(135deg, #1a1a2e, #16213e);">
    <div class="container">
        <div class="row g-4">
            <!-- About Section -->
            <div class="col-md-4">
                <h5 class="fw-bold mb-3 text-uppercase">CoreDeft</h5>
                <p class="text-muted small">Empower your future with cutting-edge online courses designed by industry experts to elevate your skills.</p>
                <div class="social-icons mt-3">
                    <a href="#" class="social-link text-white me-3" aria-label="Facebook"><i class="fab fa-facebook-f fa-lg hover-scale"></i></a>
                    <a href="#" class="social-link text-white me-3" aria-label="Twitter"><i class="fab fa-twitter fa-lg hover-scale"></i></a>
                    <a href="#" class="social-link text-white me-3" aria-label="LinkedIn"><i class="fab fa-linkedin-in fa-lg hover-scale"></i></a>
                    <a href="#" class="social-link text-white" aria-label="Instagram"><i class="fab fa-instagram fa-lg hover-scale"></i></a>
                </div>
            </div>

            <!-- Quick Links -->
            <div class="col-md-2">
                <h5 class="fw-bold mb-3 text-uppercase">Quick Links</h5>
                <ul class="list-unstyled">
                    <li><a href="#" class="text-muted text-decoration-none hover-link">Home</a></li>
                    <li><a href="#" class="text-muted text-decoration-none hover-link">Courses</a></li>
                    <li><a href="#" class="text-muted text-decoration-none hover-link">About</a></li>
                    <li><a href="#" class="text-muted text-decoration-none hover-link">Contact</a></li>
                </ul>
            </div>

            <!-- Contact Info -->
            <div class="col-md-3">
                <h5 class="fw-bold mb-3 text-uppercase">Get in Touch</h5>
                <ul class="list-unstyled text-muted small">
                    <li class="mb-2">
                        <i class="fas fa-map-marker-alt me-2"></i>
                        K.B.I Road, Gaffargaon, Bangladesh
                    </li>
                    <li class="mb-2">
                        <i class="fas fa-phone me-2"></i>
                        <a href="tel:+8801750045130" class="text-muted text-decoration-none hover-link">+880 1750-045130</a>
                    </li>
                    <li>
                        <i class="fas fa-envelope me-2"></i>
                        <a href="mailto:info@coredeft.com" class="text-muted text-decoration-none hover-link">info@coredeft.com</a>
                    </li>
                </ul>
            </div>

            <!-- Contact Form -->
            <div class="col-md-3">
                <h5 class="fw-bold mb-3 text-uppercase">Quick Contact</h5>
                <form id="footerContactForm" class="row g-2">
                    <div class="col-12">
                        <input type="text" class="form-control fcf rounded-3" placeholder="Name" required>
                    </div>
                    <div class="col-12">
                        <input type="email" class="form-control fcf rounded-3" placeholder="Email" required>
                    </div>
                    <div class="col-12">
                        <textarea class="form-control fcf rounded-3" placeholder="Message" rows="3" required></textarea>
                    </div>
                    <div class="col-12">
                        <button type="submit" class="btn btn-gradient w-100 rounded-3 text-uppercase fw-semibold">Send</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Footer Bottom -->
        <div class="border-top border-muted mt-5 pt-3 text-center">
            <p class="mb-0 small text-muted">
                © 2025 CoreDeft. Developed by
                <a href="https://asiburrahman.com/" target="_blank" class="text-white fw-semibold text-decoration-none hover-link">Asibur Rahman Aravi</a>
            </p>
        </div>
    </div>
</footer>

<style>
    .footer {
        background: linear-gradient(135deg, #1a1a2e, #16213e);
        color: #e0e0e0;
    }

    .footer h5 {
        color: #ffffff;
        letter-spacing: 0.5px;
    }

    .footer .text-muted {
        color: #b0b0b0 !important;
    }
    .social-link {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 36px;
        height: 36px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
        color: #ffffff;
        text-decoration: none;
        transition: all 0.3s ease;
    }

    .social-link:hover {
        background: #3b82f6;
        transform: translateY(-3px);
    }
    .hover-link {
        transition: color 0.3s ease;
    }

    .hover-link:hover {
        color: #ffffff !important;
    }

    
    .hover-scale {
        transition: transform 0.3s ease;
    }

    .hover-scale:hover {
        transform: scale(1.2);
    }

    .fcf {
        background-color: #2a2a3e;
        border: none;
        color: #ffffff;
        transition: all 0.3s ease;
    }

    .fcf:focus {
        background-color: #2a2a3e;
        box-shadow: 0 0 0 0.2rem rgba(255, 255, 255, 0.1);
        color: #ffffff;
    }

    .fcf::placeholder {
        color: #8a8a9e;
    }

    .btn-gradient {
        background: linear-gradient(90deg, #00008b, #9333ea);
        border: none;
        border-radius: 8px;
        padding: 10px;
        color: #ffffff;
        transition: all 0.3s ease;
    }

    .btn-gradient:hover {
        background: linear-gradient(90deg, #2563eb, #7e22ce);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
    }

    .border-muted {
        border-color: rgba(255, 255, 255, 0.1) !important;
    }

    @media (max-width: 767.98px) {
        .footer .social-icons {
            text-align: center;
        }

        .footer .social-icons a {
            margin: 0 10px;
        }
    }
</style>

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    $(document).ready(function() {
        $('#footerContactForm').on('submit', function(e) {
            e.preventDefault();
            // Add your form submission logic here
            const formData = {
                name: $(this).find('input[type="text"]').val(),
                email: $(this).find('input[type="email"]').val(),
                message: $(this).find('textarea').val()
            };
            console.log('Form submitted:', formData);
            // Example: You could add a toast notification here
            // showToast('Message sent successfully!', 'success');
            this.reset();
        });
    });
</script>